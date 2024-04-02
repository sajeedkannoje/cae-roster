<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->resource->id,
            'date'            => $this->resource->date,
            'check_in_utc'    => $this->resource->check_in_utc,
            'check_out_utc'   => $this->resource->check_out_utc,
            'activity'        => $this->resource->activity,
            'remark'          => $this->resource->remark,
            'from'            => $this->resource->from,
            'std_utc'         => $this->resource->std_utc,
            'to'              => $this->resource->to,
            'sta_utc'         => $this->resource->sta_utc,
            'hotel'           => $this->resource->hotel,
            'blh'             => $this->resource->blh,
            'night_time'      => $this->resource->night_time,
            'duration'        => $this->resource->duration,
            'pax_booked'      => $this->resource->pax_booked,
            'ac_registration' => $this->resource->ac_registration,
            'crew_id'         => $this->resource->crew_id,
            'is_imported'     => $this->resource->is_imported,

        ];
    }
}
