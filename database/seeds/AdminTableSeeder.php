<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
	        'email'    => 'admin@gmail.com',
	        'password' => Hash::make('techchain.vn'),
	        'role'     => config('constant.superAdmin'),
	    ]);
        DB::table('settings')->insert([
            'time'      => config('constant.timeExam'),
            'paginate'  => config('constant.paginate'),
        ]);
    }
}
