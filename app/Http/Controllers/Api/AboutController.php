<?php

namespace App\Http\Controllers\Api;

use App\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        return $this->ApiResponse(true , [] , __('site.about_us') ,About::first() ,200);
    }
}
