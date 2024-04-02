<?php

namespace App\Import\RosterBusterImport;

/**
 *
 */
trait RosterBusterParser
{

    /**
     * @param array $data
     *
     * @return array
     */
    public function parseRosterDataToLocalField(array $data): array
    {
        return [
            "date"            => $this->activityDate,
            "check_in_utc"    => isset($data['ciz']) ? date("H:i", strtotime($data['ciz'])) : null,
            "check_out_utc"   => isset($data['coz']) ? date("H:i", strtotime($data['coz'])) : null,
            "activity"        => $data["activity"],
            "remark"          => $data["remark"],
            "from"            => $data["from"],
            "std_utc"         => isset($data['stdz']) ? date("H:i", strtotime($data['stdz'])) : null,
            "to"              => $data["to"],
            "sta_utc"         => isset($data['staz']) ? date("H:i", strtotime($data['staz'])) : null,
            "hotel"           => $data["achotel"],
            "blh"             => $data["blh"],
            "night_time"      => $data["night_time"],
            "duration"        => $data["dur"],
            "pax_booked"      => $data["pax_booked"],
            "ac_registration" => $data["acreg"],
            "is_imported"     => true,
            "crew_id"         => $this->activityImportRequest->get('crew_id'),
        ];
    }


}
