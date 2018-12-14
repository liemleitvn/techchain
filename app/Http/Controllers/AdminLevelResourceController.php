<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use App\Models\Level;
use App\Repositories\Eloquents\LevelRepository;
class AdminLevelResourceController extends Controller
{
    protected $level;
    public function __construct(LevelRepository $level){
        $this->level = $level;
    }
    public function index()
    {
        $paginate =10;
        $data = $this->level->getBy()->paginate($paginate);
        return view('layouts.admin.pages.level',compact('data'));
    }

    public function create(Request $rq)
    {
        
    }

    public function store(Request $rq)
    {
        if($rq->data){
            $data_add = ['name'=>$rq->data];
            $this->level->create($data_add);
            return response()->json(['success'=>Lang::get('messages.success.add')]) ;
        }
        return response()->json(['error'=>Lang::get('messages.name.empty')]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id, Request $rq)
    {
        
    }

    public function update(Request $rq, $id)
    {
        if(Level::find($id) && $rq->data){
            $data_update = ['name'=>$rq->data];
            $this->level->update($id,$data_update);
            return response()->json(['success'=>Lang::get('messages.success.update')]) ;
        } else return response()->json(['error'=>Lang::get('messages.error.edit')]) ;
    }

    public function destroy($id)
    {
        if(Level::find($id)){
            $this->level->delete($id);
            return response()->json(['success'=>Lang::get('messages.success.delete')]) ;
        } else return response()->json(['error'=>Lang::get('messages.error.delete')]) ;  
    }
}
