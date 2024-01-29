<?php

namespace App\Http\Controllers;

use App\Enums\ShipmentEquipmentTypesEnum;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Inertia\Response;

class ShipmentController extends Controller
{
    public function index(): Response
    {
        return inertia('Shipment/Index', [
            'shipments' => Shipment::with([
                'company',
                'marginStops',
            ])->when(request()->query('search'), function ($query, $search) {
                $query->where('order_id', 'like', "%$search%");
            })->simplePaginate(8)->withQueryString(),
            'filters' => request()->only('search', 'active', 'closed')
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => ['required', 'unique:shipments,order_id'],
            'weight' => ['required', 'numeric', 'between:1,55000'],
            'temperature' => ['numeric', 'between:-50,100', 'nullable'],
            'equipment_type' => ['required', Rule::in(ShipmentEquipmentTypesEnum::values())],
            'notes' => ['string', 'max:256', 'nullable'],
        ]);

        $shipment = Shipment::create(array_merge($validated, [
            'user_id' => auth()->user()->id
        ]));

        return back()->with('flash.banner', "Shipment $shipment->order_id added");
    }

    public function show(Shipment $shipment)
    {
        return inertia('Shipment/Show', [
            'shipment' => $shipment->load(
                'members',
                'comments.user',
                'stops',
                'company',
                'driverLocations'
            )]);
    }


    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'order_id' => [
                'bail',
                'required',
                Rule::unique('shipments', 'order_id')->ignore($shipment->id),
            ],
            'weight' => ['bail', 'required', 'numeric', 'between:1,80000'],
            'temperature' => ['numeric', 'between:-50,100', 'nullable'],
            'equipment_type' => ['required'],
            'notes' => ['string', 'max:256', 'nullable'],
        ]);

        $shipment->update($validated);

        return back()->with('flash.banner', "Shipment updated");
    }

    public function destroy(Shipment $shipment)
    {
        Gate::authorize('alter-shipment', [$shipment, 'Not authorized to delete this shipment']);

        $order = $shipment->order_id;

        $shipment->delete();

        return redirect()->route('shipments.index')->with('flash.banner', "Shipment $order destroyed");
    }
}
