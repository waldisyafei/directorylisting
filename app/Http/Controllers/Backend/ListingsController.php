<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use Validator;
use Auth;
use Setting;
use Storage;
use Image;
use Mail;
use Session;
use App\Models\ListingEdit;
use App\Models\History;

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

    public function index_noncust()
    {
        $listings = Listing::where('customer_id', Auth::user()->get()->user_id)->orderBy('created_at', 'DSC')->paginate(10);

        return view('backend.pages.listing.list-noncust', ['listings' => $listings]);
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

            if ($listing->user_category == 1 ){
                $co_name = $listing->customer->name;        
            } elseif ($listing->user_category == 2 ){
                $co_name = $listing->customer->customer_name;
            }else{
                $co_name = $listing->customer->nonsub_name; 
            }

            $listing->save();

            $this->suspend_mail(['name' => $co_name, 'listing_name' => $listing->title, 'email' => $listing->pic_email]);

            return redirect('app-admin/listings')->with('success', 'Listing suspended successfully');
        }
    }


    public function create()
    {
        $listing_limit = Auth::user()->get()->listing_limit;
        $user_listings = count(Auth::user()->get()->listings);


        return view('backend.pages.listing.buy');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         if (!Auth::user()->get()->can('can_create_listing')) {
            return redirect()->back();
        }

        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'keywords' => 'required',
            'tags' => 'required',
            'images' => 'required'
            ]);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $listing = new Listing;

        $listing->title = $request->input('title');
        if ($request->input('category') != 'choose-category') {
            $listing->category = $request->input('category');
        } else {
            $listing->category = 0;
        }
        $listing->content = $request->input('content');
        $listing->keywords = $request->input('keywords');
        $listing->tags = $request->input('tags');
        $listing->assets = json_encode($request->input('images'));

        if ($listing->save()) {
            return redirect('app-admin/listings/edit/'. $listing->id)->with('success', 'Listing created successfully.');
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
        $rules = [
            'title' => 'required|min:2|max:255',
            'sub_category' => 'required',
            'content' => 'required|max:' . Setting::get('listings.content_length'),
            'review' => 'max:' . Setting::get('listings.content_length'),
            'custom_tab' => 'max:' . Setting::get('listings.content_length')
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return redirect()->back()->withInput()->withErrors($validation);
        }

        $listing_old = Listing::find($id);
        $listing_old->status = 2;

        $listing = new ListingEdit;
        $listing->customer_id = Auth::user()->get()->user_id;
            $listing->user_category = 1;
        $listing->listing_edit_id = $listing_old->listing_id;
        $listing->status = 2;
        $listing->edit = $listing_old->id;
        $listing->title = $request->input('title');
        $listing->content = $request->input('content');
        $listing->review = $request->input('review');
        $listing->custom_tab = $request->input('custom');
        $listing->custom_tab_title = $request->input('custom_title');
        $listing->keywords = $request->input('keywords');
        $listing->tags = $request->input('tags');
        $listing->url = $request->input('url');
        $listing->price_from = $request->input('price_from');
        $listing->price_to = $request->input('price_to');
      //  $listing->package_id = $request->input('package');
        if ($request->input('category') != 'choose-category') {
            $listing->category = $request->input('sub_category');
        }

        
        if ($request->hasFile('image')) {
            //$dir = storage_path().'/app/listings/assets/';
            $dir = public_path().'/storage/app/listings/assets/';
            $file = $request->file('image');
            $file_name = preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
            $thumb_admin = 'thumb-admin-'.$file_name;
            $thumb = 'thumb-'.$file_name;
            $relative_path = 'storage/app/listings/assets/'.$file_name;
            $relative_thumb_admin_path = 'storage/app/listings/assets/'.$thumb_admin;
            $relative_path = 'storage/app/listings/assets/'.$file_name;

            if (!Storage::disk('local')->exists('listings/assets')) {
                Storage::makeDirectory('listings/assets');
            }

            Image::make($request->file('image'))->save($dir . $file_name);
            Image::make($request->file('image'))->resize(150, 120)->save($dir . $thumb_admin);
            Image::make($request->file('image'))->resize(200, 200)->save($dir . $thumb);

            $listing->assets = json_encode([$relative_path]);
        }elseif ($listing_old->assets) {
            $listing->assets = $listing_old->assets;
        }

        $history = new History;
        $history->customer_id = $listing->customer_id;
        $history->item_id = $listing_old->listing_id;
        $history->item_type = 'listing';

        $history_old = new History;
        $history_old->customer_id = $listing_old->customer_id;
        $history_old->item_id = $listing_old->listing_id;
        $history_old->item_type = 'listing';

        if ($listing->save()) {
            $listing_old->save();
            $history->save();
            $history_old->save();
            return redirect('app-admin/listings/noncust')->with('success', 'Listing created successfully.');
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
        if (!Auth::user()->get()->can('can_delete_listing')) {
            return redirect()->back();
        }
        $listing = Listing::find($id);

        if ($listing) {
            $listing->delete();

            return redirect()->back()->with('success', 'Listing deleted successfully.');
        }
    }

    public function upload_image(Request $request)
    {
        //return "berhasil ke server";

        if (!$request->ajax()) {
            return abort(403);
        }
    
        if ($request->hasFile('image')) {
            $dir = storage_path().'/app/listings/assets/';
            $file = $request->file('image');
            $file_name = preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
            $thumb_admin = 'thumb-admin-'.$file_name;
            $thumb = 'thumb-'.$file_name;
            $relative_path = 'storage/app/listings/assets/assets/'.$file_name;
            $relative_thumb_admin_path = 'storage/app/listings/assets/assets/'.$thumb_admin;
            $relative_path = 'storage/app/listings/assets/assets/'.$file_name;
            
            if (!Storage::disk('local')->exists('listings/assets')) {
                Storage::makeDirectory('listings/assets');
            }

            Image::make($request->file('image'))->save($dir . $file_name);
            Image::make($request->file('image'))->resize(150, 120)->save($dir . $thumb_admin);
            Image::make($request->file('image'))->resize(200, 200)->save($dir . $thumb);

            return response()->json([
                'status' => 'success',
                'relative_path' => $relative_path,
                'relative_thumb_admin_path' => $relative_thumb_admin_path
                ]);
        }
    }



    /*=============================================
    =            Get Listing Statistics           =
    =============================================*/
    public function statistics(Request $request)
    {
        if (!$request->ajax()) {
            return abort(403);
        }

        $now_date = date('Y-m-d H:i:s');
        $start_date = strtotime($now_date . ' -20 days');
        $statistics = ListingMeta::where('listing_id', $request->input('listing_id'))
                        ->whereDate('created_at', '>=', $start_date)->orderby('created_at', 'ASC')->get();

        $listing = Listing::find($request->input('listing_id'));

        $data = array();

        foreach ($statistics as $key => $statistic) {
            $data[] = array(
                'date' => date('Y-m-d', strtotime($statistic->created_at)),
                'value' => $statistic->meta_value
                );
        }

        return response()->json($data);
    }

    public function wizard()
    {
        return view('customer.pages.listing.buy-listing');
    }

    public function buy()
    {
        return view('customer.pages.listing.buy');
    }
    
    public function buy_listing_slot(Request $request)
    {
        $listing_id = array();

        foreach ($request->input('listings') as $listingRequest) {
            $listing = new Listing;
            $listing->customer_id = Auth::user()->get()->user_id;
            $listing->user_category = 1;
            $listing->address_id = Auth::user()->get()->address_id;
            $listing->package_id = $listingRequest['package_id'];
            
            //$stop_date = Package::find($listing->package_id)->days;//dd($stop_date);
            //$listing->expired_date = date('Y-m-d H:i:s', strtotime($stop_date));//dd($listing->expired_date);
            
            $listing->save();

            $listing->listing_id = strtoupper($this->generateListingID() . $listing->id);

            $listing->save();
            $package_price = $listing->package->price;
            $disc = $listing->package->discount;
            $potongan = $disc / 100 * $package_price;
            $total = $package_price - $potongan;
            create_billing($listing->customer_id, $listing->id, 'listing', $total, 1);

            $listing_id[] = $listing->id;
        }

        $listings = array();
        foreach ($listing_id as $id) {
            $listings[] = Listing::find($id);
        }

        Session::put('listings', $listings);

        return redirect('app-admin/listings/buy/complete');
    }

    private function generateListingID()
    {
        $customerName = Auth::user()->get()->user_id;
        $customerNameFormat = $this->clean($customerName);

        return $customerNameFormat;
    }

    private function clean($string) {
        $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function buyComplete()
    {
        if (Session::has('listings')) {
            $listings = Session::get('listings');
            //Session::forget('listings');
        } else {
            return redirect('account/listings');
        }

        return view('backend.pages.listing.buy-complete', array('listings' => $listings));
    }

    public function getSubcategory(Request $request)
    {
        $category = ListingCategory::find($request->input('main_id'));

        if (!$category) {
            return response()->json(array(
                'status' => 'error'
            ));
        }
        return response()->json(array(
            'status' => 'success',
            'categories' => $category->children->toArray()
        ));
    }

    public function renew()
    {
        return view('customer.pages.listing.renew');
    }

    public function renew_listing_slot(Request $request)
    {
        $listing_id = array();

        foreach ($request->input('listings') as $key => $listingRequest) {
            if ($listingRequest['package_id'] != '--- SELECT PACKAGE ---') {
                $listing = Listing::where('listing_id', $key)->first();
                $listing->package_id = $listingRequest['package_id'];

                if ($listing->status == 5) {
                    $listing->status = 1;
                }

                $listing->save();
                $package_price = $listing->package->price;
                $disc = $listing->package->discount;
                $potongan = $disc / 100 * $package_price;
                $total = $package_price - $potongan;
                create_billing($listing->customer_id, $listing->id, 'listing', $total);

                $listing_id[] = $listing->id;
            }
        }

        $listings = array();
        foreach ($listing_id as $id) {
            $listings[] = Listing::find($id);
        }

        Session::put('listings', $listings);

        return redirect('account/listings/buy/complete');
    }

    public function suspend_mail($data){
        Mail::send('backend.pages.listing.mail_suspend', $data, function($message) use ($data){
            $message->to($data['email'], $data['name'])->subject('Klik Virtual -  Suspended Listing Notification');
            $message->from('noreplay@klikvirtual.com', 'Noreplay - Klik Virtual');
        });
    }
}
