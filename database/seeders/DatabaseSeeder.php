<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\User;
use Faker\Generator as Faker; 
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        $users = User::all();
        foreach($users as $user){
            $imageNumber = rand(1,2);
            $photo = new Photo();
            $photo->user_id = $user->id;
            $photo->image = $imageNumber.".jpg";
            $photo->save();
        }
    }
}
