<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Auth,DB;
use Carbon\Carbon;
use App\Repositories\Eloquents\UserRepository;
class CheckUserLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:timeUserLogin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check time using of user on website';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $user;
    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    
    public function checkTime($time,$id){
        if($time > config('constant.timeout')){
            $data= ['is_disable'=>config('constant.disable')];
            $this->user->update($id,$data);
        }
    }
    public function handle()
    {
        $users = $this->user->getAll();
        foreach($users as $user){
            $check_time = (Carbon::now()->timestamp - Carbon::createFromTimeStamp(strtotime($user['created_at']))->timestamp)/60;
            if($check_time > config('constant.timeout')){
               $this->checkTime($check_time,$user['id']);
            }
        }
    }
}
