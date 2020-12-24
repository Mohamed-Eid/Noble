<?php

namespace App\Http\Controllers\Dashboard;

use App\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Validation\Rule;

class DetailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_details'])->only('index');
        $this->middleware(['permission:create_details'])->only('store');

    }

    public function index(){
        $cities = City::all();
        $products = Product::all();
        return View('dashboard.details.create',compact('cities'));
    }

    public function store(Request $request)
    {
        $rules = ['products' => 'required|min:1'];
        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required' ,Rule::unique('city_translations','name')]];
        }
        $request->validate($rules);

        $products_ids = request()->products;
        
        //$subdetails = request()->subdetails;
        //dd($subdetails[0]);
        $subdetails = $this->proccess_subdetails(request()->subdetails);
        $data = request()->all();

        unset($data['products']);
        unset($data['subdetails']);

        //dd($data);

        foreach($products_ids as $id){
            $product = Product::find($id);
            $detail = $product->details()->create($data);

            if(count($subdetails)>0)
            {
                foreach($subdetails as $subdetail){
                    $detail->subdetails()->create($subdetail);
                }
            }
        }

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.details');

    }

    protected function proccess_subdetails($subdetails)
    {
        $data = [];
        foreach ($subdetails as $subdetail) {
            if(!($subdetail['ar']['name'] == null || $subdetail['en']['name'] == null))
            {
                $data[] = $subdetail;
            }
        }
        return $data;
    }
}
