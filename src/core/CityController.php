<?php
namespace App\core;

use App\contracts\RouteGeneratorInterface;

/**
 * Class CityController
 * @package App\Http\Controllers
 */
class CityController implements RouteGeneratorInterface
{
    protected $service;

    /**
     * return all records
     * @return mixed
     */
    public function getCities()
    {

    }

    /**
     * return specific record
     * @param Int $cityID
     * @return City
     */
    public function getCity($cityID)
    {
    }

    public function postCity($parametr)
    {

    }

    public function patchCity($cityId)
    {

    }
}
