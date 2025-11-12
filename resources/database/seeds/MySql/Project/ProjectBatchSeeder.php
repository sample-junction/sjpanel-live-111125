<<<<<<< HEAD
<?php

use Illuminate\Database\Seeder;

class ProjectBatchSeeder extends Seeder
{
    use DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->call(ProjectStatusTableSeeder::class);
        $this->call(ProjectTopicSeeder::class);

        $this->enableForeignKeys();
    }
}
=======
<?php

use Illuminate\Database\Seeder;

class ProjectBatchSeeder extends Seeder
{
    use DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->call(ProjectStatusTableSeeder::class);
        $this->call(ProjectTopicSeeder::class);

        $this->enableForeignKeys();
    }
}
>>>>>>> dev
