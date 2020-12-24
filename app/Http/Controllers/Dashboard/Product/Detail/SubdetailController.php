<?php

namespace App\Http\Controllers\Dashboard\Product\Detail;

use App\Detail;
use App\Subdetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class SubdetailController extends Controller
{
    
    public function __construct()
    {
        $this->middleware(['permission:read_subdetails'])->only('index');
        $this->middleware(['permission:create_subdetails'])->only('store');
        $this->middleware(['permission:update_subdetails'])->only('update');
        $this->middleware(['permission:delete_subdetails'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product , Detail $detail)
    {
        $edit = false;
        return view('dashboard.products.details.subdetails.index' , compact('product','detail','edit'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product , Detail $detail)
    {
        $rules = [
            'price' => 'integer|min:0',
            'profit' => 'integer|min:0'

        ];
        
        $indexes = [];

        foreach ($detail->subdetails as $subdetail) {
            $indexes[] = $subdetail->sort;
        }
        //dd($indexes);
        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required']];
        }

        $rules += ['sort' => [
            'required',
            'integer',
            'min:1',
            Rule::notIn($indexes) 
            ]
        ];

        $request->validate($rules);


        //dd($request->all());
        $data = $request->all();
        if ($request->image) {
            Image::make($request->image)->save(public_path('uploads/product_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }
        
        if ($request->icon) {
            Image::make($request->icon)->save(public_path('uploads/product_images/' . $request->icon->hashName()));
            $data['icon'] = $request->icon->hashName();
        }

        //dd($data);
        $detail->subdetails()->create($data);
    
        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.subdetails.index',[
                'product' => $product,
                'detail' => $detail
                ]);
    }

    public function edit(Product $product ,Detail $detail , Subdetail $subdetail)
    {
        $edit = true;
        return view('dashboard.products.details.subdetails.index' , compact('product','detail','subdetail','edit'));

    }

    public function update(Request $request, Product $product , Detail $detail, Subdetail $subdetail)
    {
        $rules = [
            'price' => 'integer|min:0',
            'profit' => 'integer|min:0'

        ];
        $indexes = [];
        //dd($detail->subdetails);
        foreach ($detail->subdetails as $subdetaill) {
            if($subdetaill->sort != $subdetail->sort)
            {
                $indexes[] = $subdetaill->sort;
            }
        }
       // dd($indexes);
        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required']];
        }
        
        $rules += ['sort' => [
            'required',
            'integer',
            'min:1',
            Rule::notIn($indexes)
            ]
        ];

        $request->validate($rules);

        $data = $request->all();

        if ($request->image) {

            if ($product->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
            }
            Image::make($request->image)->save(public_path('uploads/product_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }
        
        if ($request->icon) {

            if ($product->icon != 'default.png') {
                Storage::disk('public_uploads')->delete('/product_images/' . $product->icon);
            }
            Image::make($request->icon)->save(public_path('uploads/product_images/' . $request->icon->hashName()));
            $data['icon'] = $request->icon->hashName();
        }

        $subdetail->update($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.subdetails.index',['product' => $product , 'detail'=>$detail]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subdetail  $subdetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product , Detail $detail, Subdetail $subdetail)
    {

        if ($subdetail->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/product_images/' . $subdetail->image);
        }
        $subdetail->delete();

        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.details.subdetails.index',[
            'product' => $product,
            'detail' => $detail
            ]);
    }
}
