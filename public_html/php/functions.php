<?php

function calc_price($arrival, $departure, $apartment)
{
    $price = 0;
    $interval = date_diff(date_create($arrival), date_create($departure));
    $nights = $interval->format('%a');
    $nights = (int)$nights;
    $arrival_date = date('N', strtotime($arrival));
    $departure_date = date('N', strtotime($departure));
    $year = substr($arrival, 0, 4);
    if (($arrival >= $year . '-01-05' && $arrival < $year . '-02-12') || ($arrival >= $year . '-02-27' && $arrival < $year . '-04-02')) {
        if ($nights >= 7) {
            $weeks = $nights / 7;
            $extradays = $nights % 7;
            $price = $apartment['price_week_regular'] * $weeks + $apartment['price_night_regular'] * $extradays;
        } else if ($nights == 2 && $arrival_date == 5 && $departure_date == 7) {
            $price = $apartment['price_weekend_regular'];
        } else if ($nights < 7 && $nights > 0) {
            $price = $nights * $apartment['price_night_regular'];
        } else {
            die("Error.The dates submited are not valid!");
        }
    }
    if (($arrival >= $year . '-04-02' && $arrival < $year . '-04-23') || ($arrival >= $year . '-05-24' && $arrival < $year . '-06-15') || ($arrival >= $year . '-09-04' && $arrival < $year . '-10-16') || ($arrival >= $year . '-10-31' && $arrival < $year . '-12-16')) {
        if ($nights >= 7) {
            $weeks = $nights / 7;
            $extradays = $nights % 7;
            $price = $apartment['price_week_season'] * $weeks + $apartment['price_night_season'] * $extradays;
        } else if ($nights == 2 && $arrival_date == 5 && $departure_date == 7) {
            $price = $apartment['price_weekend_season'];
        } else if ($nights < 7 && $nights > 0) {
            $price = $nights * $apartment['price_night_season'];
        } else {
            die("Error. The dates submited are not valid!");
        }
    }

    if (($arrival >= $year . '-02-12' && $arrival < $year . '-02-27') || ($arrival >= $year . '-04-23' && $arrival < $year . '-05-24') || ($arrival >= $year . '-06-15' && $arrival < $year . '-09-04') || ($arrival >= $year . '-10-16' && $arrival < $year . '-10-31') || ($arrival >= $year . '-12-16' && $arrival < ++$year . '-01-05')) {
        if ($nights >= 7) {
            $weeks = $nights / 7;
            $extradays = $nights % 7;
            $price = $apartment['price_week_season'] * $weeks + $apartment['price_night_season'] * $extradays;
        } else if ($nights == 2 && $arrival_date == 5 && $departure_date == 7) {
            $price = $apartment['price_weekend_season'];
        } else if ($nights < 7 && $nights > 0) {
            $price = $nights * $apartment['price_night_season'];
        } else {
            die("Error. The dates submited are not valid!");
        }
    }
    $price = number_format($price, 2, '.', '');
    return $price;
}
