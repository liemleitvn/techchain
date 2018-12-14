<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Eloquents\CategoryRepository;
use App\Repositories\Eloquents\SkillRepository;
use App\Repositories\Eloquents\ResultRepository;
use Auth;
use App\Models\Setting;
class UIComposer
{
    protected $category,$skill,$result;

    public function __construct(CategoryRepository $category, SkillRepository $skill,ResultRepository $result)
    {
        $this->category = $category;
        $this->skill    = $skill;
        $this->result   = $result;
    }

    public function compose(View $view)
    {   
        if(Auth::check()){
            $user = Auth::user();
            $count_answer = $this->result->getBy()->where('user_id',$user->id)->count('id');
            $category_id_of_user = $this->category->getBy()->where('id',$user->category_id)->first();
            $view->with('auth_user', $user);
            $view->with('count_answer', $count_answer);
            $view->with('category_id_of_user', $category_id_of_user);
            $view->with('time_exam', Setting::select('time')->first());
            $view->with('data_results', $this->result->getBy()->where('user_id',$user->id)->get());
        }
    }
}