<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\City;
use App\District;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = City::all();
        $categories = Category::all();

        // $data = [];        
        // $products = Product::all();
        // foreach($products as $product)
        // {
        //     $data[] = $product->name;
        // }
        // dd($data);

        $products = Product::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%')->orWhere('sku', $request->search);
            //return $q->where('sku','%' . $request->search . '%');
        })->when($request->city_id, function ($q) use ($request) {

            return $q->where('city_id', $request->city_id);

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->orderBy('id')->orderBy('sort')->paginate(20);
        
        //dd($products);
        return view('dashboard.products.index', compact('cities','categories' ,'products'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$districts = District::all();
        $cities = City::all();
        $categories = Category::all();

        return view('dashboard.products.create' , compact('cities','categories'));
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
            'sku' => 'required|unique:products',
            'profit' => 'required|min:0',
        ];


        foreach (config('translatable.locales') as $locale){
            //$rules += [$locale.'.name' => ['required' ,Rule::unique('product_translations','name')]];
            $rules += [$locale.'.name' => ['required']];
        }

        
        
        $data = $request->all();
        
        if($data['discount']==null)
        {
            $data['discount'] = 0;
        }

        if(isset($data['active'])){
            $data['active'] = 1;  
        }
        
        if(isset($data['tafsil'])){
            $data['tafsil'] = 1;  
        }

        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }
        
        // $indexes = [];
        // $products = Product::where('category_id',request()->category_id);

        // foreach ($products as $product) {
        //     $indexes[] = $product->sort;
        // }
        
        // $rules += ['sort' => [
        //     //'required',
        //     // 'integer',
        //     // 'min:1',
        //     Rule::notIn($indexes)
        //     ]
        // ];  
        
        $request->validate($rules);
 

        $product = Product::create($data);

        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.details.index' , ['product' => $product]);

        //return redirect()->route('dashboard.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $cities = City::all();
        $categories = Category::all();

        return view('dashboard.products.edit' , compact('product','cities','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $rules = [
            'sku' => 'required|unique:products,sku,'.$product->id,
            'profit' => 'required|min:0',
        ];

        //$rules += ['sku' => ['required' ,Rule::unique('products','sku')->ignore($product->id,'product_id')]];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required']];
        }

        $data = $request->all();

        if ($request->image) {

            if ($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }
        if(isset($data['tafsil'])){
            $data['tafsil'] = 1;  
        }else{
           $data['tafsil'] = 0; 
        }
        
        if(isset($data['active'])){
            $data['active'] = 1;  
        }else{
           $data['active'] = 0; 
        }
        
        if($data['discount']==null)
        {
            $data['discount'] = 0;
        }
        
        $indexes = [];
        $products = Product::where('city_id',request()->city_id);

        foreach ($products as $pro) {
            if($pro->sort != $product->sort)
            {
                $indexes[] = $pro->sort;
            }
        }
        
        $rules += ['sort' => [
            //'required',
            // 'integer',
            // 'min:1',
            Rule::notIn($indexes)
            ]
        ];  

        $request->validate($rules);

        $product->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
        }

        $product->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.products.index');
    }
}
