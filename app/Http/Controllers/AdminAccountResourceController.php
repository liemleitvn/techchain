<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AccountAdminRequest;
use Lang,DB,Hash,Auth;
use App\Repositories\Eloquents\AdminRepository;

class AdminAccountResourceController extends Controller
{
    protected $amdin;
    public function __construct(AdminRepository $admin)
    {
        $this->admin = $admin;
    }
    public function index(){   
        $auth_admin = Auth::guard('admin')->user();
        $data = $this->admin->getBy()->where('id','<>',$auth_admin->id)->get();
        return view('layouts.admin.pages.account-admin',compact('data'));
    }
    public function create()
    {
        //
    }
    public function store(AccountAdminRequest $request)
    {
        $data = [
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => config('constant.manager')
        ];
        DB::beginTransaction();
        try{
            $this->admin->create($data);
            DB::commit();
        } catch(\Exception $e){
           DB::rollBack();
           return response()->json(['error'=>Lang::get('messages.error.add.database')]);
        }
        return response()->json(['success'=>Lang::get('messages.success.add')]);
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try{
            $this->admin->update($id,[
                'password' => Hash::make($request->data['password'])
            ]);
            return response()->json(['success'=>Lang::get('messages.success.update')]) ;
        } catch(\Exception $e){
           return response()->json(['error'=>Lang::get('messages.error.edit')]) ;
        }
    }

    public function destroy($id)
    {
        try{
            $this->admin->delete($id);
            return response()->json(['success'=>Lang::get('messages.success.delete')]);
        } catch(\Exception $e){
            return response()->json(['error'=>Lang::get('messages.error.delete')]);
        }
    }

    public function changePassword(Request $request,$id){
        $data = $request->data;
        $auth_admin = Auth::guard('admin')->user();
        $data_check = [
            'email'     => $auth_admin->email,
            'password'  => $data['c_password']
        ];

        if(Hash::check($data['c_password'], $auth_admin->password) && strlen($data['n_password']) >5){
            try{
                $this->admin->update($id,[
                    'password' => Hash::make($data['n_password'])
                ]);
                return response()->json(['success'=>Lang::get('messages.success.update')]);
            } catch(\Exception $e){
                return response()->json(['error'=>Lang::get('messages.error.update')]);
            }
        }
        return response()->json(['error'=>Lang::get('messages.error.change.admin')]);
    }
}
