<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->search , function ($q) use ($request){
            return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->latest()->paginate(20);


        return view('dashboard.categories.index' , compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');

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
            $rules += [$locale.'.name' => ['required' ,Rule::unique('category_translations','name')]];
        }

        $request->validate($rules);
        
        $data = $request->all();

        $data['ar']['image'] = 'default.png';
        $data['en']['image'] = 'default.png';

        if( isset($request->ar['image'])) {
            Image::make($request->ar['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/category_images/' . $request->ar['image']->hashName()));
             $data['ar']['image'] = $request->ar['image']->hashName();
        }
        
        if( isset($request->en['image'])) {
            Image::make($request->en['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/category_images/' . $request->en['image']->hashName()));
             $data['en']['image'] = $request->en['image']->hashName();
        }
        
        //dd($data);
        Category::create($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.categories.index');
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
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //dd($category);
        $rules = [];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required' ,Rule::unique('category_translations','name')->ignore($category->id,'category_id')]];
        }

        $request->validate($rules);

        $data = $request->all();

        if( isset($request->ar['image'])) {
            Image::make($request->ar['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/category_images/' . $request->ar['image']->hashName()));
             $data['ar']['image'] = $request->ar['image']->hashName();
        }
        
        if( isset($request->en['image'])) {
            Image::make($request->en['image'])->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/category_images/' . $request->en['image']->hashName()));
             $data['en']['image'] = $request->en['image']->hashName();
        }
        

        
        $category->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        foreach(config('translatable.locales') as $locale){
            if ($category->translate($locale)->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/category_images/' . $category->translate($locale)->image);
            } 
        }
        $category->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.categories.index');
    } 
}
