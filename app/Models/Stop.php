<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property string $type
 * @property string $status
 * @property Carbon $eta
 * @property Carbon $datetime
 * @property Carbon $arrival_datetime
 * @property Carbon $departure_datetime
 * @property bool $fcfs
 * @property Carbon $working_hours_start
 * @property Carbon $working_hours_end
 * @property string $ref_numbers
 * @property string $street_address
 * @property string $city
 * @property string $state
 * @property string $zip_code
 * @property string $country
 * @property string $notes
 * @property int $lat
 * @property int $lng
 * @property int $shipment_id
 *
 * @property-read Collection $shipment
 */
class Stop extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }

}
