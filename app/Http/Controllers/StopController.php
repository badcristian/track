<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStopRequest;
use App\Models\Shipment;
use App\Models\Stop;
use Illuminate\Support\Facades\Gate;

class StopController extends Controller
{
    public function store(StoreStopRequest $request, Shipment $shipment)
    {
        $shipment->stops()->create($request->validated());

        return redirect()->back()->with('flash.banner', 'Stop added');
    }

    public function update(StoreStopRequest $request, Shipment $shipment, Stop $stop)
    {
        $shipment->fill($request->except('id', 'created_at'));

        $shipment->save();

        return redirect()->back()->with('flash.banner', "Stop updated");
    }

    public function destroy(Shipment $shipment, Stop $stop)
    {
        $stop->delete();

        return redirect()->back()->with('flash.banner', "Stop destroyed");
    }
}
