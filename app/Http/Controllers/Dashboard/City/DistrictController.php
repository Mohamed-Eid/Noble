<?php

namespace App\Http\Controllers\Dashboard\City;

use App\City;
use App\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(City $city)
    {
        return view('dashboard.cities.districts.index' , compact('city'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , City $city)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required' ,Rule::unique('detail_translations','name')]];
        }

        $request->validate($rules);

        $city->districts()->create($request->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.cities.districts.index',['city' => $city]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, District $district)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city ,District $district)
    {
        $district->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.cities.districts.index',['city' => $city]);
    }
}
