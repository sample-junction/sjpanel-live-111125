<<<<<<< HEAD
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesRealatedToReferralProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('referral_programs')) {
            Schema::create('referral_programs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->integer('points');
                $table->string('uri');
                $table->integer('lifetime_minutes')->default(7 * 24 * 60);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('referral_links')) {
            Schema::create('referral_links', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('referral_program_id')->unsigned();
                $table->string('code', 36)->index();
                $table->unique(['referral_program_id', 'user_id']);
                $table->timestamps();

                $table->foreign('referral_program_id')->references('id')->on('referral_programs')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('referral_relationships')) {
            Schema::create('referral_relationships', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('referral_link_id');
                $table->integer('user_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('referral_links');
        Schema::dropIfExists('referral_programs');
        Schema::dropIfExists('referral_relationships');
        Schema::enableForeignKeyConstraints();
    }
}
=======
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesRealatedToReferralProgram extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('referral_programs')) {
            Schema::create('referral_programs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->integer('points');
                $table->string('uri');
                $table->integer('lifetime_minutes')->default(7 * 24 * 60);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('referral_links')) {
            Schema::create('referral_links', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned();
                $table->integer('referral_program_id')->unsigned();
                $table->string('code', 36)->index();
                $table->unique(['referral_program_id', 'user_id']);
                $table->timestamps();

                $table->foreign('referral_program_id')->references('id')->on('referral_programs')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
        }

        if (!Schema::hasTable('referral_relationships')) {
            Schema::create('referral_relationships', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('referral_link_id');
                $table->integer('user_id');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('referral_links');
        Schema::dropIfExists('referral_programs');
        Schema::dropIfExists('referral_relationships');
        Schema::enableForeignKeyConstraints();
    }
}
>>>>>>> dev
