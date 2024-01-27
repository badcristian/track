<?php

namespace App\Models;

use App\Enums\ShipmentUserRolesEnum;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property string $order_id
 * @property string $status
 * @property int $weight
 * @property int $temperature
 * @property string $equipment_type
 * @property string $notes
 * @property int $user_id
 *
 * @property-read Collection $members
 * @property-read Collection|null $driverLocations
 * @property-read Comment $comments
 * @property-read Stop $stops
 * @property-read Collection $marginStops
 * @property-read Stop $firstStop
 * @property-read Stop $lastStop
 * @property-read Company $ownerCompany
 * @property-read Collection|null $brokers
 * @property-read Collection|null $drivers
 * @property-read Collection|null $dispatchers
 */
class Shipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'shipment_user',
            'shipment_id',
            'user_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function driverLocations(): HasMany
    {
        return $this->hasMany(DriverLocation::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function stops(): HasMany
    {
        return $this->hasMany(Stop::class, 'shipment_id', 'id');
    }

    public function marginStops(): HasMany
    {
        return $this->stops()
            ->where('datetime', function ($query) {
                $query->from('stops as sub')
                    ->selectRaw('min(datetime)')
                    ->whereRaw('stops.shipment_id = sub.shipment_id');
            })->orWhere('datetime', function ($query) {
                $query->from('stops as sub2')
                    ->selectRaw('max(datetime)')
                    ->whereRaw('stops.shipment_id = sub2.shipment_id');
            })->orderBy('dateTime');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company(): HasOneThrough
    {
        return $this->hasOneThrough(
            Company::class,
            User::class,
            'id',
            'id',
            'user_id',
            'company_id'
        );
    }

    public function brokers(): BelongsToMany
    {
        return $this->members()->where('role', ShipmentUserRolesEnum::broker->value);
    }

    public function drivers(): BelongsToMany
    {
        return $this->members()->where('role', ShipmentUserRolesEnum::driver->value);
    }

    public function dispatchers(): BelongsToMany
    {
        return $this->members()->where('role', ShipmentUserRolesEnum::dispatcher->value);
    }
}
