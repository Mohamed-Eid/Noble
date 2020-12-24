<?php

namespace App\Http\Controllers\Dashboard\Product;

use App\Color;
use App\Coupon;
use App\Detail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image as AppImage;
use App\Product;
use App\Size;
use App\Video;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;



class DetailController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_details'])->only('index');
        $this->middleware(['permission:create_details'])->only('store');
        $this->middleware(['permission:update_details'])->only('update');
        $this->middleware(['permission:delete_details'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $edit = false;
        $size_edit = false;
        $color_edit = false;
        $coupon_edit = false;
        return view('dashboard.products.details.index' , compact('product','coupon_edit', 'edit','color_edit','size_edit'));
    }

    public function upload_images(Product $product)
    {
        $images = Collection::wrap(request()->file('file'));
        //dd($images);
        $images->each(function ($image) use ($product){
            $image_name = Str::random();
            $image_name = $image_name .'.'. $image->getClientOriginalExtension();

            Image::make($image)
                ->save(public_path('uploads/product_images/'.$image_name));

            $product->images()->create([
                'image' => $image_name,
            ]);
        });

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);
    } 
    
    public function upload_videos(Product $product)
    {

        $videos = Collection::wrap(request()->file('file'));
        //dd($images);
        $videos->each(function ($video) use ($product){
            $video_name = Str::random();
            $video_name = $video_name .'.'. $video->getClientOriginalExtension();
            $file_path = 'uploads/product_videos/';

            $video->move($file_path, $video_name);
            
            $product->videos()->create([
                'video' => $video_name,
            ]);
        });
        
        // $data = [];
        // foreach ($request->files->all()['files'] as $file) {
        //     $file_name = time() . $file->getClientOriginalName();                      
        
        //     $file_path = 'uploads/special_orders/';
        
        //     $file->move($file_path, $file_name);
        //     $data[] = $file_name;
        // }
        
        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);
    } 

    public function delete_images(Product $product, AppImage $image)
    {
        //delete the file
        File::delete(
            $image->image_public_path
        );
        //delete the record
        
        $image->delete();

        //return back
        return redirect()->route('dashboard.products.details.index',['product'=>$product]);
    } 
    
    public function delete_videos(Product $product, Video $video)
    {
        File::delete(
            $video->video_public_path
        );
        //delete the record
        
        $video->delete();

        //return back
        return redirect()->route('dashboard.products.details.index',['product'=>$product]);
    } 


    //sizes

    public function add_sizes(Product $product)
    {

        request()->validate([
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'depth' => 'required',
            'cost' => 'required',
        ]);

        $product->sizes()->create(request()->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);
    }
    public function edit_sizes(Product $product, Size $size)
    {

        //dd($size);
        $edit = false;
        $size_edit = true;
        $color_edit = false;
        $coupon_edit = false;
        
        return view('dashboard.products.details.index' , compact('product','coupon_edit','size_edit','color_edit','size','edit'));

    }
    public function update_sizes(Product $product, Size $size)
    {

        //dd($size);
        request()->validate([
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'depth' => 'required',
            'cost' => 'required',
        ]);
        
        $size->update(request()->all());

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);

    }
    public function delete_sizes(Product $product, Size $size)
    {

        $size->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);

    }

    //speacial sizes
    public function add_special_sizes(Product $product)
    {

        // request()->validate([
        //     'length_cost' => 'required',
        //     'width_cost' => 'required',
        //     'height_cost' => 'required',
        //     'depth_cost' => 'sometimes',
        // ]);

        $product->update(request()->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);
    }
    public function edit_special_sizes(Product $product, Size $size)
    {

        //dd($size);
        $edit = false;
        $size_edit = true;
        $color_edit = false;
        $coupon_edit = false;
        return view('dashboard.products.details.index' , compact('product','coupon_edit','size_edit','color_edit','size','edit'));

    }
    public function update_special_sizes(Product $product, Size $size)
    {

        //dd($size);
        request()->validate([
            'length' => 'required',
            'width' => 'required',
            'height' => 'required',
            'depth' => 'required',
            'cost' => 'required',
        ]);
        
        $size->update(request()->all());

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);

    }

    //colors
    public function add_colors(Product $product)
    {
        $rules = ['cost' => 'required'];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required']];
        }
        request()->validate($rules);

        $product->colors()->create(request()->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);
    }
    public function edit_colors(Product $product, Color $color)
    {

       // dd($color);
        $edit = false;
        $size_edit = false;
        $color_edit = true;
        $coupon_edit = false;

        return view('dashboard.products.details.index' , compact('product','coupon_edit','size_edit','color_edit','color','edit'));

    }
    public function update_colors(Request $request, Product $product, Color $color)
    {
        //dd(request()->all());
        $rules = ['cost' => 'required'];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required']];
        }

        request()->validate($rules);
        
        $color->update($request->all());
        
        //$color->update(request()->all());

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);

    }
    public function delete_colors(Product $product, Color $color)
    {
        //dd($color);

        $color->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);

    }


    //details
    public function add_details(Request $request , Product $product)
    {
        $rules = [];
        $indexes = [];
        
        foreach ($product->details as $detail) {
            $indexes[] = $detail->sort;
        }

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

        $product->details()->create($request->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product'=>$product]);
    }
    public function edit_details(Product $product, Detail $detail)
    {

        //dd($detail);
        $edit = true;
        $size_edit = false;
        $color_edit = false;
        $coupon_edit = false;

        return view('dashboard.products.details.index' , compact('product','coupon_edit','size_edit','color_edit','detail','edit'));

    }
    public function update_details(Request $request, Product $product , Detail $detail)
    {
        $rules = [];
        $indexes = [];
        
        foreach ($product->details as $detaill) {
            if($detaill->sort != $detail->sort)
            {
                $indexes[] = $detaill->sort;
            }
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

        $detail->update($request->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product' => $product]);
    }
    public function delete_details(Product $product , Detail $detail)
    {
        $detail->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.products.details.index',['product' => $product]);
    }








/////////old code////////////////










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
    public function store(Request $request , Product $product)
    {
        $rules = [];
        $indexes = [];
        
        foreach ($product->details as $detail) {
            $indexes[] = $detail->sort;
        }

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

        $product->details()->create($request->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product' => $product]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function show(Detail $detail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product ,Detail $detail)
    {
        $edit = true;

        return view('dashboard.products.details.index' , compact('product','detail','edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product , Detail $detail)
    {
        $rules = [];
        $indexes = [];
        
        foreach ($product->details as $detaill) {
            if($detaill->sort != $detail->sort)
            {
                $indexes[] = $detaill->sort;
            }
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

        $detail->update($request->all());

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.products.details.index',['product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Detail  $detail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product , Detail $detail)
    {
        $detail->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.products.details.index',['product' => $product]);
    }
}
