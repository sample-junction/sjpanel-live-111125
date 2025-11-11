<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('survey_status_code');
            $table->integer('survey_priority');
            $table->string('survey_name');
            $table->string('country_code');
            $table->string('language_code');
            $table->integer('client_cpi');
            $table->string('live_url');
            $table->string('test_url');
            $table->string('is_active')->default("true");
            $table->integer('quota');
            $table->integer('cpi');
            $table->integer('loi');
            $table->integer('ir');
            $table->integer('unique_pid')->nullable();
            $table->string('unique_ip_address')->nullable();
            $table->string('is_dedupe');
            $table->string('is_geoip');
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
        Schema::dropIfExists('projects');
    }
}
