<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
class ComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.admin.layouts.menu-left','App\Http\ViewComposers\MenuComposer');
        View::composer('layouts.front-end.layouts.header','App\Http\ViewComposers\UIComposer');
        View::composer('layouts.front-end.layouts.content-question','App\Http\ViewComposers\UIComposer');
        View::composer('layouts.front-end.pages.home','App\Http\ViewComposers\UIComposer');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
