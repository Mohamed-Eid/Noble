<?php

namespace App\Http\Controllers\Dashboard;

use App\Download;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{
    public function index()
    {
        $download = Download::first();
        if($download)
           return view('dashboard.download.edit',compact('download'));
        
        $download = new Download();
        return view('dashboard.download.edit',compact('download'));
    }

    public function update(Request $request)
    {

        $download = Download::first();

        if($download){
            $download->update(
                [
                    'play_store_link' => request()->play_store_link,
                    'app_store_link'  => request()->app_store_link,
                ]
            );
        }else{
            $download = Download::create(                [
                'play_store_link' => request()->play_store_link,
                'app_store_link'  => request()->app_store_link,
            ]);
        }


        //return $about;
        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.download',compact('download'));
    }
}
