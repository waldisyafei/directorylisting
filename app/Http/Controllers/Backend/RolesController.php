<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('created_at', 'DESC')->paginate(15);

        return view('backend.pages.roles.list', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
            ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $role = new Role;
        $role->display_name = $request->input('name');
        $role->name = strtolower(str_replace(' ', '_', $request->input('name')));
        $role->description = $request->input('desc');

        if ($role->save()) {
            if ($request->has('perms') && $request->input('perms') > 0) {
                $permissions = array();
                foreach ($request->input('perms') as $perm) {
                    $permissions[] = $perm;
                }
                $role->perms()->sync($permissions);
            }
            return redirect('app-admin/roles/edit/'.$role->id)->with('success', 'Role created successfully');
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
        $role = Role::find($id);
        if ($role) {
            return view('backend.pages.roles.edit', ['role' => $role]);
        }

        return abort(404, 'Request not found');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255'
            ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $role = Role::find($id);
        $role->display_name = $request->input('name');
        $role->name = strtolower(str_replace(' ', '_', $request->input('name')));
        $role->description = $request->input('desc');

        if ($role->save()) {
            if ($request->has('perms') && $request->input('perms') > 0) {
                $permissions = array();
                foreach ($request->input('perms') as $perm) {
                    $permissions[] = $perm;
                }
                $role->perms()->sync($permissions);
            }

            return redirect('app-admin/roles/edit/'.$role->id)->with('success', 'Role created successfully');
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
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return redirect('app-admin/roles')->with('success', 'Role deleted successfully.');
        }
    }
}
