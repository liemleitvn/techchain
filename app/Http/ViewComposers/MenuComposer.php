<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Repositories\Eloquents\CategoryRepository;
use App\Repositories\Eloquents\SkillRepository;

class MenuComposer
{
    protected $category,$skill;

    public function __construct(CategoryRepository $category, SkillRepository $skill)
    {
        $this->category = $category;
        $this->skill    = $skill;
    }

    public function compose(View $view)
    {
        $view->with('cates', $this->category->getByASC()->get());
        $view->with('skills', $this->skill->getByASC()->get());
    }
}