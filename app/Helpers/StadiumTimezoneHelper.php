<?php

namespace App\Helpers;

class StadiumTimezoneHelper
{
    public static function fromCity(string $city, string $country): string
    {
        $city = strtolower($city);
        $country = strtolower($country);

        return match (true) {

            // 🇲🇽 México
            str_contains($city, 'mexico city') => 'America/Mexico_City',
            str_contains($city, 'guadalajara') => 'America/Mexico_City',
            str_contains($city, 'monterrey') => 'America/Monterrey',

            // 🇺🇸 Estados Unidos (zonas principales)
            str_contains($city, 'seattle') => 'America/Los_Angeles',
            str_contains($city, 'san francisco') => 'America/Los_Angeles',
            str_contains($city, 'los angeles') => 'America/Los_Angeles',
            str_contains($city, 'santa clara') => 'America/Los_Angeles',

            str_contains($city, 'miami') => 'America/New_York',
            str_contains($city, 'atlanta') => 'America/New_York',
            str_contains($city, 'new york') => 'America/New_York',
            str_contains($city, 'philadelphia') => 'America/New_York',
            str_contains($city, 'boston') => 'America/New_York',
            str_contains($city, 'houston') => 'America/Chicago',
            str_contains($city, 'dallas') => 'America/Chicago',
            str_contains($city, 'kansas') => 'America/Chicago',

            // 🇨🇦 Canadá
            str_contains($city, 'toronto') => 'America/Toronto',
            str_contains($city, 'vancouver') => 'America/Vancouver',

            // fallback
            default => 'UTC',
        };
    }
}