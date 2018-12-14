<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lang;
use App\Models\Category;
use App\Models\Skill;
use App\Repositories\Eloquents\CategoryRepository;
use App\Repositories\Eloquents\SkillRepository;
class AdminCategoryResourceController extends Controller
{
    protected $skill;
    protected $category;
    public function __construct(SkillRepository $skill,CategoryRepository $category){
        $this->skill = $skill;
        $this->category = $category;
    }
    public function index()
    {
        $paginate =10;
        $data_skill = $this->skill->getBy()->where('is_can_add_category',1)->get();
        $data_cate = $this->category->getBy()->paginate($paginate);
        return view('layouts.admin.pages.category',compact('data_skill','data_cate'));
    }

    public function create(Request $rq)
    {
        
    }

    public function store(Request $rq)
    {
        $data = $rq->data;
        $data_add =['name'=>$data['name_category'],'skill_id'=>$data['skill_id']];

        if($data['name_category'] && $data['skill_id'] > 0){
            $this->category->create($data_add);
            return response()->json(['success'=>Lang::get('messages.success.add')]) ;
        }
        return response()->json(['error'=>Lang::get('messages.name-skill-id.empty')]);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        
    }

    public function update(Request $rq, $id)
    {
        $data = $rq->data;
        
        if(Category::find($id)){
            if($data['name_category'] && $data['skill_id'] > 0){
                $data_update = [
                    'name'=>$data['name_category'],
                    'skill_id'=>$data['skill_id']
                ];
                $this->category->update($id,$data_update);
                return response()->json(['success'=>Lang::get('messages.success.update')]) ;
            } else return response()->json(['error'=>Lang::get('messages.name-skill-id.empty')]);     
        }
    }

    public function destroy($id)
    {
        if(Category::find($id)){
            $this->category->delete($id);
            return response()->json(['success'=>Lang::get('messages.success.delete')]) ;   
        } else return response()->json(['error'=>Lang::get('messages.error.delete')]) ;   
    }

}
