<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        User::create([
            'name' => 'Sergio Gento',
            'email' => 'sgentot@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('hola123'),
            'remember_token' => Str::random(10),
            'dni' => '11111111',
            'address' => '',
            'phone' => '',
            'role' => 'admin'

        ]);
        User::create([
            'name' => 'Carmen Olmo',
            'email' => 'carmenolsanch@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('hola123'),
            'remember_token' => Str::random(10),
            'dni' => '12111111',
            'address' => '',
            'phone' => '',
            'role' => 'patient'

        ]);
        User::create([
            'name' => 'lucas Gento',
            'email' => 'lgentot@hotmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('hola123'),
            'remember_token' => Str::random(10),
            'dni' => '14111111',
            'address' => '',
            'phone' => '',
            'role' => 'doctor'

        ]);
        factory(User::class,50)->states('patient')->create();

    }
}
