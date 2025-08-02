<?php

namespace App\Services;

class Notify
{
    static function successNotification()
    {
        notyf()->position('x', 'center')->position('y', 'top');
        notyf()->success('Votre dépot a étè éffectué avec success');
    }

    static function warningNotification()
    {
        notyf()->position('x', 'center')->position('y', 'top');
        notyf()->info('Merci d\'avoir emit un depot vous serez rediriger vers la page de paiement.');
    }

    static function cancelNotification()
    {
        notyf()->position('x', 'center')->position('y', 'top');
        notyf()->error('Oops votre transaction a rencontrer une erreur veuillez reesayer plus tard.');
    }
}
