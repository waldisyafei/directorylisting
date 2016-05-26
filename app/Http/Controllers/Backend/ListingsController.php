<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use Validator;
use Auth;
use Storage;
use Image;

class ListingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listings = Listing::orderBy('created_at', 'ASC')->paginate(10);

        return view('backend.pages.listing.list', ['listings' => $listings]);
    }

    public function approve($id)
    {
        $listing = Listing::find($id);

        if ($listing) {
            $listing->status = 3;

            $listing->save();

            return redirect('app-admin/listings')->with('success', 'Listing approved successfully');
        }
    }

    public function suspend($id)
    {
        $listing = Listing::find($id);

        if ($listing) {
            $listing->status = 2;

            $listing->save();

            return redirect('app-admin/listings')->with('success', 'Listing suspended successfully');
        }
    }

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
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        if (!Auth::user()->get()->can('can_edit_listing')) {
            return redirect()->back();
        }

        $listing = Listing::find($id);

        if ($listing) {
            return view('backend.pages.listing.edit', ['listing' => $listing]);
        }
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
        if (!Auth::user()->get()->can('can_edit_listing')) {
            return redirect()->back();
        }

        $validation = Validator::make($request->all(), [
            'title' => 'required'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }
        
        $listing = Listing::find($id);

        if (!$listing) {
            return abort(404);
        }

        $listing->title = $request->input('title');
        if ($request->input('category') != 'choose-category') {
            $listing->category = $request->input('category');
        } else {
            $listing->category = 0;
        }
        $listing->content = $request->input('content');
        $listing->keywords = $request->input('keywords');
        $listing->tags = $request->input('tags');
        //$listing->assets = $request->input('assets');

        if ($listing->save()) {
            return redirect('app-admin/listings/edit/'. $listing->id)->with('success', 'Listing created successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
