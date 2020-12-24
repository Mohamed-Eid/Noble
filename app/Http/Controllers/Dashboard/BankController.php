<?php

namespace App\Http\Controllers\Dashboard;

use App\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:read_banks'])->only('index');
        $this->middleware(['permission:create_banks'])->only('create');
        $this->middleware(['permission:update_banks'])->only('edit');
        $this->middleware(['permission:delete_banks'])->only('destroy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::paginate(5);
        //dd($banks);
        return view('dashboard.banks.index',compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.banks.create');
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
            'iban' => 'required',
            'account' => 'required',
        ];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required']];
            $rules += [$locale.'.bank_name' => ['required']];
        }

        $data = $request->all();

        if ($request->image) {
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/bank_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }


        $request->validate($rules);

        Bank::create($data);

        session()->flash('success', __('site.added_successfully'));

        return redirect()->route('dashboard.banks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('dashboard.banks.edit' , compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        $rules = [
            'iban' => 'required',
            'account' => 'required',
        ];

        foreach (config('translatable.locales') as $locale){
            $rules += [$locale.'.name' => ['required']];
            $rules += [$locale.'.bank_name' => ['required']];
        }

        $data = $request->all();

        if ($request->image) {

            if ($bank->image != 'default.png') {
                Storage::disk('public_uploads')->delete('/bank_images/' . $bank->image);
            }
            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
                ->save(public_path('uploads/bank_images/' . $request->image->hashName()));
            $data['image'] = $request->image->hashName();
        }


        $request->validate($rules);

        $bank->update($data);

        session()->flash('success', __('site.updated_successfully'));

        return redirect()->route('dashboard.banks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        if ($bank->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/bank_images/' . $bank->image);
        }

        $bank->delete();

        session()->flash('success', __('site.deleted_successfully'));

        return redirect()->route('dashboard.banks.index');
    }
}
