<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData =
        [
            [
                'name' => 'rapi',
                'email' => 'Admin@gmail.com',
                'usertype' => 'admin',
                'password' => bcrypt('gwsrapi')
            ],
            [
                'name' => 'givardo',
                'email' => 'bank@gmail.com',
                'usertype' => 'bank',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'hanapi',
                'email' => 'user1@gmail.com',
                'usertype' => 'user',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'filbert',
                'email' => 'user2@gmail.com',
                'usertype' => 'user',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'alex',
                'email' => 'user3@gmail.com',
                'usertype' => 'user',
                'password' => bcrypt('12345678')
            ],
            [
                'name' => 'fadli',
                'email' => 'user4@gmail.com',
                'usertype' => 'user',
                'password' => bcrypt('12345678')
            ],
        ];

        foreach ($userData as $item) {
            User::create($item);
        }
    }
}
