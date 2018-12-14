<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Lang,Hash;
use App\Models\User;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\CategoryRepository;
class AdminUserResourceController extends Controller
{
    protected $user,$category;
    public function __construct(UserRepository $user,CategoryRepository $category){
        $this->user     = $user;
        $this->category = $category;
    }
    public function index(){
        $paginate   = 10;
        $categories = $this->category->getAll();
        $users      = $this->user->getBy()->paginate($paginate);
        return view('layouts.admin.pages.user',compact('categories','users'));
    }

    public function create()
    {
        //
    }

    public function store(Request $rq){
        $data   = $rq->data;
        $email  = $data['email'];
        $validator = \Validator::make($rq->data,
            [
                'email'                 => 'required|unique:users,email|email',
            ],
            [
                'email.required'        => Lang::get('messages.username.required'),
                'email.unique'          => Lang::get('messages.username.unique'),
                'email.email'           => Lang::get('messages.username.error'),
            ]   
        );
        
        if ($validator->fails())
        {    
            return response()->json(['error'=>$validator->errors()->all()]);
        } else {
            if($this->category->getById($data['category_id'])){
                $data_add =[
                    'email'=>$data['email'],
                    'password'=>Hash::make($data['password']),
                    'phone_number'=>$data['phone'],
                    'address'=>$data['address'],
                    'cv_link'=>$data['cv_link'],
                    'category_id'=>$data['category_id'],
                    'is_disable'=>config('constant.active')
                ];

                $this->user->create($data_add);
                return response()->json(['success'=>Lang::get('messages.success.add')]);
            } else return response()->json(['error'=>Lang::get('messages.user.category')]);      
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $rq, $id)
    {
        $data_update = $rq->data;
        if(User::find($id)){
            $this->user->update($id,$data_update);
            return response()->json(['success'=>Lang::get('messages.success.update')]) ;
        }
    }

    public function destroy($id)
    {
        if(User::find($id)){
            $this->user->delete($id);
            return response()->json(['success'=>Lang::get('messages.success.delete')]) ;
        }
    }
}
