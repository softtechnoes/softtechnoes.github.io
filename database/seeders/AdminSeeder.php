<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Hash;
use App\Models\Users\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*
        * Add Super Admin User
        *
        */
        // php artisan db:seed --class=AdminSeeder
        if (\App\Models\Users\User::where('email', '=', 'softtechnoes@gmail.com')->first() === null) {

            $user = \App\Models\Users\User::create([
                'name' => 'Soft Technoes',
                'email' => 'softtechnoes@gmail.com',
                'password' => Hash::make('Password123'),
            ]);

        }else{
            $user = \App\Models\Users\User::where('email', '=', 'softtechnoes@gmail.com')->first();
        }

    }
}
