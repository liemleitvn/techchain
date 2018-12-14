<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use App\Models\Skill;
use App\Repositories\Eloquents\SkillRepository;
use App\Repositories\Eloquents\CategoryRepository;

class AdminSkillResourceController extends Controller
{
    protected $skill;
    protected $categoryRepo;


    public function __construct(SkillRepository $skill, CategoryRepository $categoryRepo){
        $this->skill = $skill;
        $this->categoryRepo = $categoryRepo;
    }
    public function index()
    {
        $paginate =10;
        $data = $this->skill->getBy()->paginate($paginate);
        $categories = $this->categoryRepo->getAll();
        return view('layouts.admin.pages.skill',compact('data', 'categories'));
    }

    public function create(Request $rq)
    {
        
    }

    public function store(Request $rq){
        $data = $rq->data;
        if($data['name_skill'] && $data['number_question'] > 0){
            $data_add =[
                'name'=>$data['name_skill'],
                'number_of_questions'=>$data['number_question'],
                'is_can_add_category'=>$data['rdio_check']
            ];

            $this->skill->create($data_add);
            return response()->json(['success'=>Lang::get('messages.success.add')]) ;
        }

        return response()->json(['error'=>Lang::get('messages.name-count.empty')]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id, Request $rq)
    {
        
    }

    public function update(Request $rq, $id){
        $data = $rq->data;

        if(Skill::find($id)){
            if($data['name_skill_edit'] && $data['number_question'] >0){
                $data_update = [
                    'name'=>$data['name_skill_edit'],
                    'number_of_questions'=>$data['number_question'],
                    'is_can_add_category'=>$data['rdio_check']
                ];
                $this->skill->update($id,$data_update);
                return response()->json(['success'=>Lang::get('messages.success.update')]) ;
            } else return response()->json(['error'=>Lang::get('messages.name-count.empty')]);    
        } return response()->json(['error'=>Lang::get('messages.error.update')]) ;
    }

    public function destroy($id)
    {
        if(Skill::find($id)){
            $this->skill->delete($id);
            return response()->json(['success'=>Lang::get('messages.success.delete')]) ;
        } else return response()->json(['error'=>Lang::get('messages.error.delete')]) ;
    }
}
