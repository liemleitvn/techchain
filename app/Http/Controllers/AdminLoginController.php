<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Lang,DB;

class AdminLoginController extends Controller
{
    public function getLogin(){
        return view('layouts.login.login');
    }

    public function postLogin(AdminLoginRequest $rq){
        $data = array(
            'email'         => $rq->username,
            'password'      => $rq->password
        );

        if(Auth::guard('admin')->attempt($data)){
            return redirect()->route('level.index');
        }
        if(Auth::attempt($data)){
            return redirect()->route('userIndex');
        } else{
            return redirect('/')->with(['error'=> Lang::get('messages.password.error')]);
        }
        
    }

    public function getLogout(){
        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
            return redirect('/');
        }
        if(Auth::check()){
            Auth::logout();
            return redirect('/');
        }
    }
}
