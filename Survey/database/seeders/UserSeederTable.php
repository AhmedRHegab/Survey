<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =  User::create([
            'name'      => 'Super Admin',
            'email'     => 'super_admin@app.com',
            'password'  => bcrypt('123456'),
            'status'    => 1,
        ]);

        $user->assignRole("Super Admin");
    }
}
