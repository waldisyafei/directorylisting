<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Package;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::orderBy('created_at', 'ASC')->paginate(10);

        return view('backend.pages.packages.list', ['packages' => $packages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'price' => 'required|numeric'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $package = new Package;
        $package->name = $request->input('name');
        $package->price = $request->input('price');
        $package->notes = $request->input('notes');
        $package->days = $request->input('days');
        $package->discount = $request->input('discount');

        if ($package->save()) {
            return redirect('app-admin/packages/edit/'.$package->id)->with('success', 'Package created successfully');
        }

        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $package = Package::find($id);

        if ($package) {
            return view('backend.pages.packages.edit', ['package' => $package]);
        }

        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'price' => 'required|numeric',
                'days' => 'required|numeric'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $package = Package::find($id);

        if (!$package) {
            return abort(404);
        }

        $package->name = $request->input('name');
        $package->price = $request->input('price');
        $package->notes = $request->input('notes');
        $package->days = $request->input('days');
        $package->discount = $request->input('discount');

        if ($package->save()) {
            return redirect('app-admin/packages/edit/'.$package->id)->with('success', 'Package updated successfully');
        }

        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = Package::find($id);

        if ($package) {
            $package->delete();

            return redirect('app-admin/packages')->with('success', 'Package deleted successfully');
        }
    }
}
