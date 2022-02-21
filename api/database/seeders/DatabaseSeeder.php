<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate(['name'=>'admin','email'=>'admin@crypto.com'],
            [
                'name'=>'admin',
                'email'=>'admin@crypto.com',
                'password'=>'123456'
            ]);
        // $this->call('UsersTableSeeder');
    }
}
