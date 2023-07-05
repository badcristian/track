<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Address;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Shipment;
use App\Models\ShipmentStop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        if (!App::environment('production')) {

            Shipment::factory()
                ->create()
                ->each(function ($shipment) {

                $users = User::factory(2)
                    ->for(Company::factory())
                    ->create();

                $shipmentStops = ShipmentStop::factory(3)->state([
                    'address_id' => fn() => Address::factory()->create(),
                    'shipment_id' => $shipment->id
                ])->create();

                $users->each(function ($user) use ($shipment){
                    $user->comments()->save(Comment::factory()->state([
                        'user_id' => $user->id,
                        'shipment_id' => $shipment->id
                    ])->create());
                });

                $shipment->users()->attach($users);
                $shipment->stops()->saveMany($shipmentStops);
            });


//
//            User::factory()
//                ->count(2)
//                ->for(Company::factory())
//                ->create();

//            Company::factory()
//                ->count(2)
//                ->has(User::factory()->count(2))
//                ->create();

        }
    }
}
