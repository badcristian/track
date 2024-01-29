<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Exception;

class ShipmentAuthException extends Exception
{

    public function render(Request $request)
    {
        return back()
                ->with('flash.banner', $this->message ?? "Not authorized")
                ->with('flash.bannerStyle', 'danger');
    }
}
