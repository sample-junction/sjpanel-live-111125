<?php

use App\Models\Project\ProjectStatus;
use Illuminate\Database\Seeder;

class ProjectStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectStatus::create([
            'code' => 'PENDING',
            'name' => 'Pending',
        ]);
        ProjectStatus::create([
            'code' => 'CANCELLED',
            'name' => 'Cancelled',
        ]);
        ProjectStatus::create([
            'code' => 'LIVE',
            'name' => 'Live',
        ]);
        ProjectStatus::create([
            'code' => 'PAUSE',
            'name' => 'Pause',
        ]);
        ProjectStatus::create([
            'code' => 'CLOSED',
            'name' => 'Closed',
        ]);
    }
}
