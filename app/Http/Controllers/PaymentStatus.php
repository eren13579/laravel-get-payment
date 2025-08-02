<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Depots;
use App\Models\Retrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentStatus extends Controller
{

    public function handleReturnUrl(Request $request) {

        $checkoutId = $request->query('checkout_id');

        if(!$checkoutId) {
            return back()->with('error', 'Erreur: ID de paiement manquant.');
        }

        $paymentDetails = $this->verifyMonerooTransaction($checkoutId);

            if ($paymentDetails && $paymentDetails['status'] === 'succeeded') {
                    $transactionRef = $paymentDetails['metadata']['transaction_ref'];
                    $depot = Depots::where('transaction_id', $transactionRef)->first();
                    if ($depot && $depot->status !== 'success') {
                        $depot->status = 'success';
                        $depot->save();
                        // Ici, vous pouvez ajouter les fonds au compte de l'utilisateur
                    }

                return view('payments.success', ['message' => 'Paiement effectué avec succès !']);
            } else {
            // Le paiement a échoué ou est en attente
            return view('payments.failed', ['message' => 'Le paiement a échoué. Veuillez réessayer.']);
        }
    }


    public function verifyMonerooTransaction(string $paymentId) {

        $secretKey = env('MONEROO_SECRET_KEY');

        $url = "https://api.moneroo.io/v1/payments/{$paymentId}/verify";
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer {$secretKey}"
            ]
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($httpCode === 200) {
            return json_decode($response, true);
        } else {
            // Enregistrer une erreur pour le débogage
            \Log::error('Moneroo verification failed', [
                'paymentId' => $paymentId,
                'httpCode' => $httpCode,
                'response' => $response
            ]);
            return null; // Retourner null en cas d'échec
        }
    }

        public function handleRetraitPayment(Request $request)
    {
        // Valide le webhook pour s'assurer qu'il vient de Moneroo
        // Récupérer le secret du webhook depuis le fichier de configuration Moneroo
        $monerooWebhookSecret = config('moneroo.webhookSecret');
        $signature = $request->header('Moneroo-Signature');

        if (!$signature || !$this->verifySignature($request->getContent(), $signature, $monerooWebhookSecret)) {
            Log::warning('Webhook signature verification failed.', ['signature' => $signature]);
            return response()->json(['message' => 'Signature invalide'], 403);
        }

        $payload = $request->json();
        $event = $payload['event'];

        Log::info("Webhook received: {$event}", ['payload_id' => $payload['data']['id'] ?? 'N/A']);

        // Traite les événements de paiement de retrait
        if (Str::startsWith($event, 'payout')) {
            $payoutId = $payload['data']['id'];
            $payoutStatus = $payload['data']['status'];

            // Trouver la transaction de retrait dans la base de données
            $retrait = Retrait::where('transaction_id', $payoutId)->first();

            if ($retrait) {
                // Mettre à jour le statut du retrait en fonction de l'événement
                $retrait->status = $payoutStatus;
                $retrait->save();
                Log::info("Payout status updated for ID: {$payoutId}. New status: {$payoutStatus}");
            } else {
                Log::warning("Retrait with transaction_id '{$payoutId}' not found.");
            }
        }

        return response()->json(['message' => 'Webhook received successfully'], 200);
    }

    /**
     * Vérifie la signature du webhook pour garantir sa légitimité.
     */
    private function verifySignature(string $payload, string $signature, string $secret): bool
    {
        $hash = hash_hmac('sha256', $payload, $secret);
        return hash_equals($signature, $hash);
    }
}
