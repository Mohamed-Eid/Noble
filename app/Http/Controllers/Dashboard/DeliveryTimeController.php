<?php

namespace App\Http\Controllers\Dashboard;

use App\Deliverytime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class DeliveryTimeController extends Controller
{
    public function index()
    {
        $times = Deliverytime::all();
        return view('dashboard.delivery_times.index',compact('times'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required' ,Rule::unique('deliverytime_translations','name')]];
        }

        $request->validate($rules);

        Deliverytime::create($request->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.times.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category ,Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deliverytime $time)
    {
        $time->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.times.index');
    }
}
