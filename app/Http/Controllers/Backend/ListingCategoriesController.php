<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use Storage;
use Image;
use App\Models\ListingCategory;

class ListingCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->get()->can('can_view_all_category')) {
            return redirect()->back();
        }

        $categories = ListingCategory::orderBy('created_at', 'ASC')->paginate(10);

        return view('backend.pages.listing.category.list', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->get()->can('can_create_category')) {
            return redirect()->back();
        }
        
        $categories = ListingCategory::count();
        if ($categories > 6 ) {
            return redirect()->back()->withErrors('Categories cannot be more than 6 categories.');
        }
        
        return view('backend.pages.listing.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Auth::user()->get()->can('can_create_category')) {
            return redirect()->back();
        }

        $validation = Validator::make($request->all(), [
            'title' => 'required'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $category = new ListingCategory;

        $category->title = $request->input('title');
        if ($request->input('parent') != 'choose-category') {
            $category->parent = $request->input('parent');
        } else {
            $category->parent = 0;
        }

        if ($category->save()) {
            return redirect('app-admin/listings/categories/edit/'. $category->id)->with('success', 'Category created successfully.');
        }
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
        if (!Auth::user()->get()->can('can_edit_category')) {
            return redirect()->back();
        }

        $category = ListingCategory::find($id);

        if ($category) {
            return view('backend.pages.listing.category.edit', ['category' => $category]);
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
        if (!Auth::user()->get()->can('can_edit_category')) {
            return redirect()->back();
        }

        $validation = Validator::make($request->all(), [
            'title' => 'required'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $category = ListingCategory::find($id);

        if (!$category) {
            return abort(404);
        }

        $category->title = $request->input('title');
        if ($request->input('parent') != 'choose-category') {
            $category->parent = $request->input('parent');
        } else {
            $category->parent = 0;
        }

        if ($category->save()) {
            return redirect('app-admin/listings/categories/edit/'. $category->id)->with('success', 'Category created successfully.');
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
        if (!Auth::user()->get()->can('can_delete_category')) {
            return redirect()->back();
        }

        $category = ListingCategory::find($id);

        if ($category) {
            $category->delete();

            return redirect()->back()->with('success', 'Category deleted successfully.');
        }
    }
}
