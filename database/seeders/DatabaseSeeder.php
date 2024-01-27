<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\StopTypesEnum;
use App\Enums\ShipmentUserRolesEnum;
use App\Models\Comment;
use App\Models\Company;
use App\Models\DriverLocation;
use App\Models\Shipment;
use App\Models\Stop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public array $stopLocations = [
        ["city" => 'Seattle, WA', 'lat' => 47.608013, 'lng' => -122.335167],
        ["city" => 'Post Falls, ID', 'lat' => 47.712257, 'lng' => -116.948364],
        ["city" => 'Salt Lake City, UT', 'lat' => 40.758701, 'lng' => -111.876183],
        ["city" => 'Denver, CO', 'lat' => 39.742043, 'lng' => -104.991531],
        ["city" => 'Chicago, IL', 'lat' => 41.881832, 'lng' => -87.623177],
        ["city" => 'Baltimore, MD', 'lat' => 39.264969, 'lng' => -76.598633]
    ];

    public array $driverLocations = [
        ["city" => 'Puyallup, WA', 'lat' => 47.177441, 'lng' => -122.292320],
        ["city" => 'Seattle, WA', 'lat' => 47.606209, 'lng' => -122.332069],
        ["city" => 'George, WA', 'lat' => 47.079170, 'lng' => -119.855858],
        ["city" => 'Clinton, MT', 'lat' => 46.7698, 'lng' => -113.7144],
        ["city" => 'Idaho Falls, MT', 'lat' => 43.491650, 'lng' => -112.033966],
        ["city" => 'Ogden, UT', 'lat' => 41.2230, 'lng' => -111.9738],
        ["city" => 'Rock Springs, WY', 'lat' => 41.5875, 'lng' => -109.2029],
        ["city" => 'Rawlings, WY', 'lat' => 41.7911, 'lng' => -107.2387],
        ["city" => 'Forth Collins, CO', 'lat' => 40.5853, 'lng' => -105.0844],
        ["city" => 'Denver, Co', 'lat' => 39.742043, 'lng' => -104.991531],
        ["city" => 'North Platte, NE', 'lat' => 41.1403, 'lng' => -100.7601],
    ];

    public function run(): void
    {
        if (!App::environment('production')) {

//            $this->addAdminUserIfDontExist();

            Company::factory()->count(10)->create();
            User::factory()->for(Company::all()->random())->create();

            Shipment::factory()
                ->count(2)
                ->for(User::all()->random(), 'creator')
                ->create()
                ->each(function ($shipment) {
                    $this->addBrokerTo($shipment);
                    $this->addDriverAndDispatcherTo($shipment);
                    $this->addDriverAndDispatcherTo($shipment);
                    $this->addCommentsTo($shipment);
                    $this->addStopsTo($shipment, $this->stopLocations);
                    $this->addDriverLocationsTo($shipment, $this->driverLocations);
                });
        }
    }

    /////////////////////////////////////////////////////////////////////////////

//    private function addAdminUserIfDontExist()
//    {
//        if (User::where('email', 'test@test.com')->doesntExist()) {
//            User::create([
//                'name' => 'John Doe',
//                'email' => 'test@test.com',
//                'phone' => '20686693404',
//                'company_id' => Company::factory()->create()->getKey(),
//            ]);
//        }
//    }

    private function addBrokerTo($shipment): void
    {
        $company = $shipment->creator->company;
        $broker = User::factory()->for($company)->create();
        $shipment->members()->attach($broker, ['role' => ShipmentUserRolesEnum::broker->value]);
    }

    private function addDriverAndDispatcherTo($shipment): void
    {
        $carrierCompany = Company::factory()->create();
        $driver = User::factory()->for($carrierCompany)->create();
        $dispatcher = User::factory()->for($carrierCompany)->create();

        $shipment->members()->attach($driver, ['role' => ShipmentUserRolesEnum::driver->value]);
        $shipment->members()->attach($dispatcher, ['role' => ShipmentUserRolesEnum::dispatcher->value]);

    }


    private function addCommentsTo($shipment): void
    {
        Comment::factory()->state([
                'user_id' => $shipment->brokers->first(),
                'shipment_id' => $shipment]
        )->create();

        Comment::factory()->state([
                'user_id' => $shipment->drivers->first(),
                'shipment_id' => $shipment]
        )->create();

        Comment::factory()->state([
                'user_id' => $shipment->dispatchers->first(),
                'shipment_id' => $shipment]
        )->create();

    }

    private function addStopsTo($shipment, $stopLocations): void
    {
        $stops = collect();

        foreach ($stopLocations as $stopCoordinates) {
            $stop = Stop::factory()
                ->for($shipment)
                ->withCoordinates($stopCoordinates)
                ->type(fake()->randomElement([StopTypesEnum::pickup, StopTypesEnum::delivery]))
                ->make();
            $stops->push($stop);
        }

        $shipment->stops()->saveMany($stops);
    }

    private function addDriverLocationsTo($shipment, $driverLocations): void
    {
        $driverId = $shipment->drivers->first()->getKey();
        foreach ($driverLocations as $locationCoordinates) {
            DriverLocation::factory()->state([
                'user_id' => $driverId,
                'shipment_id' => $shipment->getKey(),
                'lat' => data_get($locationCoordinates, 'lat'),
                'lng' => data_get($locationCoordinates, 'lng'),
                'local_time' => fake()->dateTime()
            ])->create();
        }
    }
}
