<?php

namespace App\Services;

use App\Utilities\Response;

class CityService
{
    public function getCities($data = null)
    {
        $result = getCities($data);
        return $result;
    }
    public function addCity($data)
    {
        $result = addCity($data);
        return $result;
    }
    public function changeCityName($cityName, $cityId)
    {
        $result = changeCityName($cityId, $cityName);
        if(!$result) Response::respondAndDie(["Error During Changeing City Name"] , Response::HTTP_NOT_ACCEPTABLE);
        return $result;
    }
    public function deleteCity($cityId)
    {
        $result = deleteCity($cityId);
        return $result;
    }
}