<?php

namespace App\Http\Requests;

use App\Enums\StopTypesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required', Rule::in(StopTypesEnum::values()),
            'name' => ['required'],
            "status" => [],
            "datetime" => ['required', 'date'],
            "arrival_datetime" => [],
            "departure_datetime" => [],
            "fcfs" => ['required', 'numeric', Rule::in([1, 0])],
            "working_hours_start" => ['required_if_accepted:fcfs', 'date'],
            "working_hours_end" => ['required_if_accepted:fcfs', 'date'],
            "ref_numbers" => [],
            "street_address" => ['required', 'string'],
            "city" => ['required', 'string'],
            "state" => ['required'],
            "country" => ['required'],
            "zip_code" => ['required'],
            "lat" => ['required'],
            "lng" => ['required'],
            "notes" => []
        ];
    }
}
