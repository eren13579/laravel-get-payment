<?php

return [
    'secretKey' => env('MONEROO_SECRET_KEY'),

    'methods' => [
        'NGN' => ['airtel_ng', 'ussd_ngn', 'mtn_ng', 'mtn_gh', 'airtel_gh'],
        'GHS' => ['airtel_ng', 'ussd_ngn', 'mtn_ng', 'mtn_gh', 'airtel_gh'],
        'XOF' => ['mtn_bj', 'moov_bj', 'orange_sn', 'wave_sn', 'orange_ci', 'orange_bf', 'wave_ci', 'togocel', 'orange_ml', 'card_xof', 'mtn_ci', 'moov_tg'],
        'XAF' => ['orange_cm', 'mtn_cm'],
        'GNF' => ['mtn_gf', 'mtn_gn', 'card_gnf'],
        // Méthodes par défaut si la devise n'est pas trouvée dans la liste
        'default' => ['card_usd', 'card_ngn', 'card_xof', 'card_xaf', 'bank_transfer', 'qr'],
    ],
];
