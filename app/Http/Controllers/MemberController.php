<?php

namespace App\Http\Controllers;

use App\Enums\ShipmentUserRolesEnum;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(Shipment $shipment, Request $request): JsonResponse
    {
        $request->validate([
            'search' => ['required', 'string']
        ]);

        $current_members = $shipment->members()->select('user_id');
        $search = $request->input('search');

        $users = User::query()
            ->select('id', 'name', 'email')
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->whereNotIn('id', $current_members)
            ->get();

        return response()->json([
            'users' => $users,
        ]);
    }

    public function store(Shipment $shipment, Request $request): RedirectResponse
    {
        $shipment->load('members');

        $request->validate([
            'role' => ['required', Rule::in(ShipmentUserRolesEnum::values())],
            'members' => ['required', 'array'],
            'members.*.id' => ['required', 'exists:users,id', Rule::notIn($shipment->members->pluck('id')),]
        ]);

        $members = $request->input('members');
        $role = $request->input('role');

        foreach ($members as $item) {
            $shipment->members()->attach(data_get($item, 'id'), ['role' => $role]);
        }

        return redirect()->back()->with('flash.banner', "$role" . "s" . " added");
    }

    public function destroy(Shipment $shipment, Request $request): RedirectResponse
    {
        $shipment->load('members');

        $request->validate([
            'user_id' => ['required', Rule::in($shipment->members->pluck('id'))],
        ]);

        $shipment->members()->detach($request->input('user_id'));

        return redirect()->back()->with('flash.banner', "Member deleted");
    }
}
