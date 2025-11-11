<?php

use App\Models\StaticAchievement;
use Illuminate\Database\Seeder;

class StaticAchievementTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        StaticAchievement::create([
            'code'          => 'user_joined',
            'name'          => 'user_joined',
            'description'   => 'User Joined',
            'points'        => 100,
            'order'         => 10,
        ]);

        StaticAchievement::create([
            'code'          => 'basic_details_filled',
            'name'          => 'basic_details_filled',
            'description'   => 'Basic Details Filled',
            'points'        => 100,
            'order'         => 11,
        ]);

        StaticAchievement::create([
            'code'          => 'detailed_profile_filled',
            'name'          => 'detailed_profile_filled',
            'description'   => 'Detailed Profile Filled',
            'points'        => 800,
            'order'         => 12,
        ]);
        StaticAchievement::create([
            'code'          => 'profile_pic_upload',
            'name'          => 'profile_pic_upload',
            'description'   => 'Profile Pic Upload',
            'points'        => 10,
            'order'         => 12,
        ]);

        $this->enableForeignKeys();
    }
}
