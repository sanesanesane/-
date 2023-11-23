<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Activity;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => 'test',
                     'email' => 'test@test.com',
                     'password' => Hash::make('password')]);
        $users = User::factory(10)->create();
        $users->push($user);
    }
}
