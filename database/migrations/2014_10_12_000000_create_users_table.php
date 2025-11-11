<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable.
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('access.table_names.users'), function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->timestamp('password_changed_at')->nullable();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('locale')->nullable()->default('en-US');
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('timezone')->default('UTC');

            $table->string('avatar_type')->default('gravatar');
            $table->string('avatar_location')->nullable();

            $table->string('confirmation_code')->nullable();
            $table->boolean('confirmed')->default(config('access.users.confirm_email') ? false : true);
            $table->boolean('tour_taken')->default(0);
            $table->string('image_url')->nullable();
            $table->tinyInteger('active')->default(1)->unsigned();

            $table->boolean('is_social')->default(0);
            $table->boolean('filled_basic_details')->default(0);
            $table->boolean('detailed_profile_filled')->default(0);
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->tinyInteger('email_unsubscribed')->default(0);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);


            Schema::connection(config('database.mongodb_primary', 'mongodb'))->create('user_additional_data', function (Jenssegers\Mongodb\Schema\Blueprint $collection) {
                $collection->index('uuid');
                $collection->index('u_id');
                $collection->timestamps();
            });

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(config('access.table_names.users'));

        Schema::connection(config('database.mongodb_primary', 'mongodb'))
            ->table('user_additional_data', function (Jenssegers\Mongodb\Schema\Blueprint $collection)
            {
                $collection->drop();
            });
        Schema::enableForeignKeyConstraints();
    }
}
