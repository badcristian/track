<?php

namespace App\Providers;

use App\Exceptions\ShipmentAuthException;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        Gate::define('alter-shipment', function (User $user, Shipment $shipment, string $message = null) {
            $contains = $shipment->members->contains($user);
            $is_creator = $user->is($shipment->creator);

            if (!$contains && !$is_creator) {
                throw new ShipmentAuthException($message ?? 'Not authorized to alter shipment details');
            }

            return true;
        });

        Gate::define('alter-members', function (User $user, Shipment $shipment) {

            $message = 'Not authorized to alter members';
            $apiRequest = !request()->inertia() && request()->expectsJson();

            if ($user->isNot($shipment->creator)) {
                $apiRequest ? abort(401, $message) : throw new ShipmentAuthException($message);
            }

            return true;
        });
    }
}
