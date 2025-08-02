<?php

namespace App\Http\Controllers;

use App\Models\Depots;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GetPaymentController extends Controller
{
    public function index(): View
    {
        return view('home');
    }

    public function sendDepot(Request $request): JsonResponse | RedirectResponse
    {
        $supportedCountries = array_keys(config('countries'));
        $supportedCurrencies = array_values(config('currencies.currency_list'));

        $validateRequest = $request->validate([
            'amounts' => 'required|numeric|decimal:0,2|gt:0',
            'currency' => ['required', 'string', 'size:3', Rule::in($supportedCurrencies)],
            'number' => ['required', 'string'],
            'code' => 'required|string',
            'country' => ['required', 'string', Rule::in($supportedCountries)],
            'verify' => 'accepted',
        ]);

        $depot = new Depots();
        $userId = Auth::id() ?? 1;

        $depot->user_id = $userId;
        $depot->amounts = $validateRequest['amounts'];
        $depot->number = $validateRequest['number'];
        $depot->country = $validateRequest['country'];
        $depot->currency = $validateRequest['currency'];
        $depot->country_code = $validateRequest['code'];

        $depot->verify = $validateRequest['verify'];
        $depot->status = 'pending';

        $depot->description = 'transaction electronique de l\'utilisateur' . $userId;
        $depot->transaction_id = 'TXS-' . Str::random(10) . '-' . time();

        if ($depot->save()) {
            return $this->initMonerooTransaction($depot);
        }

        $depot->status = 'cancel';
        $depot->save();
        return response()->json(['message' => 'Désolé, le paiement a échoué. Veuillez réessayer plus tard.'], 400);
    }

    /**
     * Initialise la transaction Moneroo pour un dépôt donné.
     *
     * @param Depots $depot L'objet Depots qui vient d'être sauvegardé.
     * @return \Illuminate\Http\RedirectResponse
     */
    private function initMonerooTransaction(Depots $depot) : JsonResponse | RedirectResponse
    {
        $amountInSmallestUnit = $depot->amounts;
        $methods = config('moneroo.methods.' . $depot->currency) ?? config('moneroo.methods.default');
        $user = Auth::id() ?? 1;

        $payload = [
            "amount" => (int) $amountInSmallestUnit,
            "currency" => $depot->currency,
            "description" => $depot->description,
            "customer" => [
                "email" => $user->email ?? 'tedapatrick4@gmail.com',
                "first_name" => $user->first_name ?? 'teda',
                "last_name" => $user->last_name ?? 'patrick'
            ],
            "return_url" => route('get-payment.success'),
            "metadata" => [
                "user_id" => $user,
                "transaction_ref" => $depot->transaction_id,
                "type" => "deposit"
            ],
            "methods" => $methods
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('moneroo.secretKey'), // Votre clé secrète dans le .env
                'Accept' => 'application/json',
            ])->withoutVerifying()->post('https://api.moneroo.io/v1/payments/initialize', $payload);

            if ($response->failed()) {
                \Log::error('Moneroo API Error:', $response->json());
                $depot->status = 'cancel';
                $depot->save();
                return response()->json(['message' => 'Erreur lors de l\'initialisation du paiement. Veuillez réessayer.'], 400);
            }

            $responseData = $response->json();

            if (isset($responseData['data']['checkout_url'])) {
                return response()->json(['checkout_url' => $responseData['data']['checkout_url']]);
            } else {
                \Log::error('Moneroo API did not return checkout_url:', $responseData);
                $depot->status = 'cancel';
                $depot->save();
                return response()->json(['message' => 'Impossible de procéder au dépôt. URL de paiement manquante.'], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Deposit initialization failed:', ['exception' => $e->getMessage()]);
            $depot->status = 'cancel';
            $depot->save();
            return response()->json(['message' => 'Une erreur inattendue est survenue. Veuillez réessayer.'], 500);
        }
    }
}
