<?php

namespace App\Enum;

enum Activity: string
{
    case DayOff = 'OFF';
    case StandBy = 'SBY';
    case CAR = 'CAR';
    case Flight = 'FLT';
    case CheckIn = 'CI';
    case CheckOut = 'CO';
    case Unk = 'UNK';
}
