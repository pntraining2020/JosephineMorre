<?php

use Illuminate\Database\Seeder;
use App\Models\Users;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urls = [
            'Josephine Morre',
            'Patrick Tancinco',
            'Jessavel Toring',
            'Marion Jay Balugo',
        ];

        for($i = 1; $i <= 4; $i++) {
            Users::create(array(
                'name' => $urls[$i-1], 
            ));
        }
    }
}
