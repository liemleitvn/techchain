<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB,Lang;
use App\Models\Setting;
use App\Repositories\Eloquents\LevelRepository;
use App\Repositories\Eloquents\SkillRepository;
class AdminSettingController extends Controller
{
    protected $skill,$level;
    public function __construct(LevelRepository $level,SkillRepository $skill){
        $this->level    = $level;
        $this->skill    = $skill;
    }
    public function index(){
        $levels = $this->level->getAll();
        $skills = $this->skill->getBy()->where('is_can_add_category',0)->get();
        $setting= Setting::first();
        return view('layouts.admin.pages.setting',compact('levels','skills','setting'));
    }

    public function update(Request $rq){
        $data = $rq->data;
        
        DB::beginTransaction();
        try{
            if($data['check'] == 'level' && !empty($this->level->getById($data['id']))){
                $this->level->update($data['id'],[
                    'number_of_questions' => $data['number_question']
                ]);
            } else if($data['check'] == 'skill' && !empty($this->skill->getById($data['id']))){
                $this->skill->update($data['id'],[
                    'number_of_questions' => $data['number_question']
                ]);
            } else {
                Setting::where('id',$data['id'])
                    ->update([
                        'time'      => $data['data_setting'][0],
                        'paginate'  => $data['data_setting'][1],
                    ]);
            }
            DB::commit();
        } catch(\Exception $e){
           DB::rollBack();
           return response()->json(['error'=>Lang::get('messages.error.add.database')]) ;
        }
        return response()->json(['success'=>Lang::get('messages.success.update')]) ;;
    }
}
