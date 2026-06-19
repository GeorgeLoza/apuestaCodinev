<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class StadiumTimezoneHelper
{
    public static function getTimezone(
        string $city
    ): string {

     $city = Str::lower(trim($city));

return match ($city) {

    'mexico city' => 'America/Mexico_City',
    'guadalajara (zapopan)' => 'America/Mexico_City',
    'monterrey (guadalupe)' => 'America/Monterrey',

    'toronto' => 'America/Toronto',
    'vancouver' => 'America/Vancouver',

    'miami (miami gardens)' => 'America/New_York',
    'boston (foxborough)' => 'America/New_York',
    'philadelphia' => 'America/New_York',
    'atlanta' => 'America/New_York',
    'new york/new jersey (east rutherford)' => 'America/New_York',

    'kansas city' => 'America/Chicago',
    'dallas (arlington, texas)' => 'America/Chicago',
    'houston' => 'America/Chicago',

    'seattle' => 'America/Los_Angeles',
    'los angeles (inglewood)' => 'America/Los_Angeles',
    'san francisco bay area (santa clara)' => 'America/Los_Angeles',

    default => 'UTC',
};
    }
}