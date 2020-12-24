<?php

namespace App\Http\Controllers\Dashboard;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = City::when($request->search , function ($q) use ($request){
            return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->latest()->paginate(10);


        return view('dashboard.cities.index' , compact('cities'));
    } 

 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'code' => 'required',
        ];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required' ,Rule::unique('city_translations','name')]];
            $rules += [$locale.'.currency' => ['required']];

        }
        
        $data = $request->all();
        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/city_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }

        $request->validate($rules);

        City::create($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.cities.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('dashboard.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required' ,Rule::unique('city_translations','name')->ignore($city->id,'city_id')]];
        }
        $data = $request->all();
        if ($request->image) {
            //dd($request->image);
            if ($city->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/city_images/' . $city->image);
            }
            //dd($request->image->hashName());
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save(public_path('uploads/city_images/' . $request->image->hashName()));

            //dd($request->image->hashName());

            $data['image'] = $request->image->hashName();
           // dd($data['image'] );
        }

        $request->validate($rules);

        $city->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.cities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        
        if ($city->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/city_images/' . $city->image);
        }

        $city->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.cities.index');
    }
}
