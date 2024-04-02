<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static insert( array $dayData )
 * @method static whereBetween( string $string, array $array )
 * @method static whereActivity( string $value )
 * @method static whereFrom( mixed $get )
 * @method static where( string $string, string $string1, string $string2 )
 * @method static select( string $string )
 *
 */
class Activity extends Model
{
    use HasFactory;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string[]
     */
    protected $fillable = [
        "date",
        "activity_date",
        "revision",
        "duty_code",
        "check_in_utc",
        "check_out_utc",
        "activity",
        "remark",
        "from",
        "std_utc",
        "to",
        "sta_utc",
        "hotel",
        "blh",
        "flight_time",
        "night_time",
        "duration",
        "ext",
        "pax_booked",
        "ac_registration",
        "is_imported",
        "crew_id",
    ];
}
