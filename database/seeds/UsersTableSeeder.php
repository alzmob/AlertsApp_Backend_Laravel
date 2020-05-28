<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //admin user
        $user = User::create([
            'first_name' => 'Md.Admin',
            'last_name' => '',
            'phone_number' => '01706577176',
            'email' => 'admin@alerts.com',
            'password' => Hash::make('password'),
            'status' => true,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        $user->assignRole('admin');
        //manager user
        $user = User::create([
            'first_name' => 'Md.User',
            'last_name' => '',
            'phone_number' => '01700000000',
            'email' => 'user@alerts.com',
            'password' => Hash::make('password'),
            'status' => true,
            'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        $user->assignRole('user');
    }
}
