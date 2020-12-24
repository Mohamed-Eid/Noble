<?php

namespace App\Http\Controllers\Api;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistinctResource;

class CityController extends Controller
{
    use ApiResponseTrait;

    public function all_cities()
    {
        return $this->ApiResponse(true , [] , __('api.all_cities') , CityResource::collection(City::all()) ,200);
    }

    public function get_districts_by_city_id(City $city)
    {
        return $this->ApiResponse(true , [] , __('api.all_cities') , DistinctResource::collection($city->districts) ,200);
    }
}
