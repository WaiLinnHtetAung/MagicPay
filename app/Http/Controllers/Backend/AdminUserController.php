<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\AdminUser;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreAdminUsers;
use App\Http\Requests\UpdateAdminUser;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.admin-user.index');
    }

    //server side data for datatable
    public function ssd() {
        $data = AdminUser::query();

        return Datatables::of($data)
            ->editColumn('user_agent', function($each) {
                if($each->user_agent) {
                    $agent = new Agent();
                    $agent->setUserAgent($each->user_agent);
                    $device = $agent->device();
                    $platform = $agent->platform();
                    $browser = $agent->browser();

                    return '
                        <table class="table table-sm table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td>Device</td>
                                    <td>'.$device.'</td>
                                </tr>
                                <tr>
                                    <td>Platform</td>
                                    <td>'.$platform.'</td>
                                </tr>
                                <tr>
                                    <td>Browser</td>
                                    <td>'.$browser.'</td>
                                </tr>
                            </tbody>
                        </table>
                    ';
                }

                return '-';

            })
            ->editColumn('updated_at', function($each) {
                return date_format($each->updated_at, "Y-m-d H:i:s");
            })
            ->addColumn('action', function($each) {
                $edit_icon = '<a href="'.route('admin.admin-users.edit', $each->id).'" class="text-info"><i class="bx bx-edit" ></i></a>';
                $del_icon = '<a href="" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="bx bxs-trash-alt" ></i></a>';

                return '<div class="action-icon">' . $edit_icon . $del_icon . '</div>';
            })
            ->rawColumns(['user_agent', 'action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin-user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminUsers $request)
    {
        $admin_user = AdminUser::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'password'  => Hash::make($request->password)
        ]);

        return redirect()->route('admin.admin-users.index')->with('success', 'Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdminUser  $adminUser
     * @return \Illuminate\Http\Response
     */
    public function show(AdminUser $adminUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdminUser  $adminUser
     * @return \Illuminate\Http\Response
     */
    public function edit(AdminUser $adminUser)
    {
        return view('admin.admin-user.edit', compact('adminUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdminUser  $adminUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminUser $request, AdminUser $adminUser)
    {
        $adminUser->update($request->all());

        return redirect()->route('admin.admin-users.index')->with('success', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdminUser  $adminUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminUser $adminUser)
    {
        $adminUser->delete();

        return 'success';
    }
}
