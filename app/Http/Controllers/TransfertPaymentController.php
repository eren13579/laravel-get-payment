<?php

namespace App\Http\Controllers;

use App\Models\Retrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TransfertPaymentController extends Controller
{
    public function transfertPayment(Request $request): JsonResponse | RedirectResponse
    {
        $supportedMethod = array_keys(config('method'));

        $validateRequest = $request->validate([
            'transfer_method' => ['required', 'string', Rule::in($supportedMethod)],
            'currency' => 'required|string|size:3',
            'amounts' => 'required|numeric|decimal:0,2|gt:0',
            'code' => 'required|string',
            'number' => 'required|string'
        ]);

        $retrait = new Retrait();
        $userId = Auth::id() ?? 1;

        $retrait->user_id = $userId;
        $retrait->methods = $validateRequest['transfer_method'];
        $retrait->currency = $validateRequest['currency'];
        $retrait->amounts = $validateRequest['amounts'];
        $retrait->country_code = $validateRequest['code'];
        $retrait->number = $validateRequest['number'];

        $retrait->status = 'pending';
        $retrait->description = 'retrait electronique de l\'utilisateur' . $userId;
        $retrait->transaction_id = 'TXS-' . Str::random(10) . '-' . time();


        if ($retrait->save()) {
            return $this->initMonerooTransaction($retrait);
        }

        $retrait->status = 'cancel';
        $retrait->save();
        return response()->json(['message' => 'Désolé, le paiement a échoué. Veuillez réessayer plus tard.'], 400);
    }

    private function initMonerooTransaction(Retrait $retrait): JsonResponse | RedirectResponse
    {
        $payoutPayload = [
            "amount" => (int) ($retrait->amounts),
            "currency" => $retrait->currency,
            "method" => $retrait->methods,
            "recipient" => [
                "msisdn" => $retrait->country_code . $retrait->number,
            ],
            "description" => $retrait->description,
            "customer" => [
                "email" => $user->email ?? 'erenpatrick4@gmail.com',
                "first_name" => $user->first_name ?? 'scott',
                "last_name" => $user->last_name ?? 'Gun'
            ],
            "transaction_ref" => $retrait->transaction_id,
        ];

        try {
            $response = Http::withOptions([
                'verify' => false,
            ])
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('moneroo.secretKey'),
                'Accept' => 'application/json',
            ])->post('https://api.moneroo.io/v1/payouts/initialize', $payoutPayload);

            $responseData = $response->json();

            if ($response->failed()) {
                Log::error('Moneroo Payout API Error:', $responseData);
                $retrait->update(['status' => 'cancel']);
                return response()->json(['message' => 'Échec de l\'initialisation du paiement. Veuillez réessayer.'], 400);
            }

            if (isset($responseData['data']['id'])) {
                Log::info('Moneroo Payout Success:', $responseData);
                $retrait->update(['status' => 'send']);
                return response()->json(['message' => 'Le paiement a été initialisé avec succès.'], 200);
            }

            Log::error('Moneroo Payout Unexpected Error:', $responseData);
            $retrait->update(['status' => 'cancel']);
            return response()->json(['message' => 'Une erreur inattendue est survenue. Veuillez réessayer.'], 500);
        } catch (\Exception $e) {
            Log::error('Payout initialization failed:', ['exception' => $e->getMessage()]);
            $retrait->update(['status' => 'cancel']);
            return response()->json(['message' => 'Une erreur inattendue est survenue. Veuillez réessayer.'], 500);
        }
    }

    public function verifiedTransaction(string $transactionId) : JsonResponse 
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('moneroo.secretKey'),
            ])->get("https://api.moneroo.io/v1/payouts/{$transactionId}/verify");

            $responseData = $response->json();
            
            if ($response->failed()) {
                Log::error("Moneroo Payout Verification Failed for ID: {$transactionId}", $responseData);
                return response()->json([
                    'message' => 'Échec de la vérification du paiement.',
                    'api_response' => $responseData
                ], 400);
            }

            if (isset($responseData['data']['status'])) {
                $payoutStatus = $responseData['data']['status'];
                Log::info("Moneroo Payout Verification Success for ID: {$transactionId}", $responseData);
                
                // Mettre à jour le statut dans votre base de données
                $retrait = Retrait::where('transaction_id', $transactionId)->first();
                if ($retrait) {
                    $retrait->status = $payoutStatus;
                    $retrait->save();
                }

                return response()->json([
                    'message' => 'Vérification du paiement réussie.',
                    'status' => $payoutStatus,
                    'api_response' => $responseData
                ]);
            }

            return response()->json([
                'message' => 'Réponse API inattendue lors de la vérification.'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Payout verification failed:', ['exception' => $e->getMessage()]);
            return response()->json([
                'message' => 'Une erreur interne est survenue lors de la vérification.'
            ], 500);
        }
    }
}
