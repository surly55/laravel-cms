<?php

use App\Models\User;

use Illuminate\Database\Seeder;

class UsersCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'username' => 'USERNAME',
            'email' => 'username@example.com',
            'password' => 'PASSWORD',
            'remember_token' => null,
        ]);
    }
}
