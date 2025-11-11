<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteSentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invite_sent_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->nullable();
            $table->integer('project_quota_id')->nullable()->index();
            $table->string('apace_project_code')->nullable();
            $table->integer('apace_project_quota_id')->nullable()->index();
            $table->integer('invitecnt');
            $table->integer('reminder');
            $table->integer('surveycnt');
            $table->string('user_ids','1000')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invite_sent_details');
    }
}
