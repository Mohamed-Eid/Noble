<?php

namespace App\Http\Controllers\Api;

use App\Term;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TermController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        return $this->ApiResponse(true , [] , __('site.terms') ,Term::first() ,200);
    }
}
