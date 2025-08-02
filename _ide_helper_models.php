<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $amounts
 * @property string $currency
 * @property string $number
 * @property string $decription
 * @property string $country_code
 * @property string $country
 * @property string $status
 * @property int $verify
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $users
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereAmounts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereDecription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Depots whereVerify($value)
 */
	class Depots extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $name_devise
 * @property string $code_iso
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains whereCodeIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains whereNameDevise($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DevisesAfricains whereUpdatedAt($value)
 */
	class DevisesAfricains extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $indicatif
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $devise_id
 * @property-read \App\Models\DevisesAfricains|null $currency
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain whereDeviseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain whereIndicatif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PaysAfricain whereUpdatedAt($value)
 */
	class PaysAfricain extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $first_name
 * @property string|null $last_name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 */
	class User extends \Eloquent {}
}

