<?php

namespace App\Import\RosterBusterImport;

trait RosterBusterParser
{

    public function parseRosterDataToLocalField(array $data): array
    {
        return [
            "date"            => $data["date"],
            "revision"        => $data["rev"],
            "duty_code"       => $data["dc"],
            "check_in_utc"    => $data["ciz"],
            "check_out_utc"   => $data["coz"],
            "activity"        => $data["activity"],
            "remark"          => $data["remark"],
            "from"            => $data["from"],
            "std_utc"         => $data["stdz"],
            "to"              => $data["to"],
            "sta_utc"         => $data["staz"],
            "hotel"           => $data["achotel"],
            "blh"             => $data["blh"],
            "flight_time"     => $data["flight_time"],
            "night_time"      => $data["night_time"],
            "duration"        => $data["dur"],
            "ext"             => $data["ext"],
            "pax_booked"      => $data["pax_booked"],
            "ac_registration" => $data["acreg"],
            "is_imported"     => true,
        ];
    }


}
