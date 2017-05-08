<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Setting;
use Image;
use Validator;
use App\Models\Package;
use Storage;

class SettingsController extends Controller
{
    public function site()
    {
        return view('backend.pages.settings.site');
    }

    public function store_site(Request $request)
    {
        Setting::set('site_settings.title', $request->input('site_title'));
        
        if ($request->hasFile('default_logo')) {
            //$dir = storage_path().'/app/images/assets/';
            $dir = public_path().'/storage/app/images/assets/';
            $file = $request->file('default_logo');
            $file_name = preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
            $thumb_admin = 'thumb-admin-'.$file_name;
            $thumb = 'thumb-'.$file_name;
            $relative_path = 'storage/app/images/assets/'.$file_name;
            $relative_thumb_admin_path = 'storage/app/images/assets/'.$thumb_admin;
            $relative_path = 'storage/app/images/assets/'.$file_name;

            if (!Storage::disk('local')->exists('images/assets')) {
                Storage::makeDirectory('images/assets');
            }

            Image::make($request->file('default_logo'))->save($dir . $file_name);
            Image::make($request->file('default_logo'))->resize(150, 120)->save($dir . $thumb_admin);
            Image::make($request->file('default_logo'))->resize(200, 200)->save($dir . $thumb);

            Setting::set('site_settings.default_logo', $relative_path);
        }

        Setting::set('site_settings.enable_sessional_logo', $request->input('enable_sessional_logo'));

        if ($request->input('enable_sessional_logo') == 'on') {
        
            if ($request->hasFile('sessional_logo')) {
                //$dir = storage_path().'/app/images/assets/';
                $dir = public_path().'/storage/app/images/assets/';
                $file = $request->file('sessional_logo');
                $file_name = 'sessional-' . preg_replace("/[^A-Z0-9._-]/i", "_", $file->getClientOriginalName());
                $thumb_admin = 'thumb-admin-'.$file_name;
                $thumb = 'thumb-'.$file_name;
                $relative_path = 'storage/app/images/assets/'.$file_name;
                $relative_thumb_admin_path = 'storage/app/images/assets/'.$thumb_admin;
                $relative_path = 'storage/app/images/assets/'.$file_name;

                if (!Storage::disk('local')->exists('images/assets')) {
                    Storage::makeDirectory('images/assets');
                }

                Image::make($request->file('sessional_logo'))->save($dir . $file_name);
                Image::make($request->file('sessional_logo'))->resize(150, 120)->save($dir . $thumb_admin);
                Image::make($request->file('sessional_logo'))->resize(200, 200)->save($dir . $thumb);

                Setting::set('site_settings.sessional_logo', $relative_path);
            }
            Setting::set('site_settings.sessional_show', $request->input('show_date'));
            Setting::set('site_settings.sessional_end', $request->input('end_date'));
        }

        Setting::set('site_settings.announcement', $request->input('announcement'));

        Setting::save();

        return redirect()->back()->with('success', 'Site settings updated.');
    }

    public function packages()
    {
        $packages = Package::orderBy('created_at', 'ASC')->paginate(15);

        return view('backend.pages.packages.list', ['packages' => $packages]);
    }

    public function pricing_setup()
    {
        $packages = Package::orderBy('created_at', 'ASC')->paginate(15);

        return view('backend.pages.settings.pricing_setup', ['packages' => $packages]);
    }

    public function store_package(Request $request)
    {
        # code...
    }

    public function listings()
    {
        return view('backend.pages.settings.listings');
    }

    public function store_listings(Request $request)
    {
        $validator = Validator::make($request->all(), ['content_length' => 'required|numeric']);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors();
        }

        Setting::set('listings.content_length', $request->input('content_length'));
        Setting::save();

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function ads()
    {
        return view('backend.pages.settings.ads');
    }

    public function store_ads(Request $request)
    {
        $validator = Validator::make($request->all(), ['content_length' => 'required|numeric']);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors();
        }

        Setting::set('ads.content_length', $request->input('content_length'));
        Setting::save();

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function content_lenght()
    {
        return view('backend.pages.settings.content_lenght');
    }

    public function store_content_lenght(Request $request, $type)
    {
        if($type == 'listing'){
            $validator = Validator::make($request->all(), ['content_length' => 'required|numeric']);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors();
            }

            Setting::set('listings.content_length', $request->input('content_length'));
            Setting::save();

            return redirect()->back()->with('success', 'Settings updated successfully');
        }else{
            $validator = Validator::make($request->all(), ['content_length' => 'required|numeric']);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors();
            }

            Setting::set('ads.content_length', $request->input('content_length'));
            Setting::save();

            return redirect()->back()->with('success', 'Settings updated successfully');       
        }
        
    }

    public function expiry(Request $request)
    {
        $validator = Validator::make($request->all(), ['almost_expired' => 'required|numeric', 'auto_suspend' => 'required|numeric', 'auto_delete' => 'required|numeric']);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors();
        }

        Setting::set('site_settings.almost_expired', $request->input('almost_expired'));
        Setting::set('site_settings.auto_suspend', $request->input('auto_suspend'));
        Setting::set('site_settings.auto_delete', $request->input('auto_delete'));
        Setting::save();

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function ads_price()
    {
        return view('backend.pages.settings.ads-price');
    }

    public function set_ads_price(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'price' => 'required|numeric'
        ));

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors();
        }

        Setting::set('ads.price_per_day', $request->input('price'));
        Setting::set('ads.price_discount', $request->input('discount'));
        Setting::set('ads.price_notes', $request->input('notes'));
        Setting::save();

        return redirect()->back()->with('success', 'Settings updated successfully');
    }

    public function noncustset_ads_price(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'price' => 'required|numeric'
        ));

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors();
        }

        Setting::set('ads.noncust.price_per_day', $request->input('price'));
        Setting::set('ads.noncust.price_discount', $request->input('discount'));
        Setting::set('ads.noncust.price_notes', $request->input('notes'));
        Setting::save();

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
