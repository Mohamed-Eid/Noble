<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\About;

class AboutController extends Controller
{
    public function about_us()
    {
        $about = About::first();
        if($about)
            //return $about;
           return view('dashboard.about.edit',compact('about'));
        
        $about = About::create([
            'ar'=>[
                'body' => 'ar',
            ],
            'en'=>[
                'body' => 'en',
            ],
        ]);
        return view('dashboard.about.edit',compact('about'));
    }

    public function update(Request $request)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.body' => ['required']];
        }
        $about = About::first();

        $request->validate($rules);
      
        $about->update(
            [
                'ar'=>[
                    'body' => request()->ar['body'],
                ],
                'en'=>[
                    'body' => request()->en['body'],
                ],
            ]
        );
        //return $about;
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.abouts',compact('about'));
    }

}
