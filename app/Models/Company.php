<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $name
 * @property string $mc
 * @property string $dot
 * @property string $about
 * @property string $street_address
 * @property string $city
 * @property string $state
 * @property string $zip_code
 * @property string $country
 * @property string $phone
 * @property string $email
 *
 * @property-read Collection|null $users
 */

class Company extends Model
{
    use HasFactory;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
