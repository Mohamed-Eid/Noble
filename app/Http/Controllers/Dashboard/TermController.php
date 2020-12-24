<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Term;

class TermController extends Controller
{
    public function index()
    {
        $about = Term::first();
        if($about)
           return view('dashboard.terms.edit',compact('about'));
        
        $about = Term::create([
            'ar'=>[
                'body' => 'ar',
            ],
            'en'=>[
                'body' => 'en',
            ],
        ]);
        return view('dashboard.terms.edit',compact('about'));
    }

    public function update(Request $request)
    {
        $rules = [];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.body' => ['required']];
        }
        $about = Term::first();

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

        return redirect()->route('dashboard.terms',compact('about'));
    }

}
