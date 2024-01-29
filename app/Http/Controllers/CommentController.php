<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Shipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Shipment $shipment): RedirectResponse
    {
        Gate::authorize('alter-shipment', $shipment);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:256'],
            'user_id' => ['required', 'exists:users,id']
        ]);

        $shipment->comments()->create($validated);

        return redirect()->back()->with('flash.banner', 'Comment added');
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
