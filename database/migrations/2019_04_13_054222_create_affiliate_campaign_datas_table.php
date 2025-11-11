<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAffiliateCampaignDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_campaign_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('aff_camp_id');
            $table->integer('source_id');
            $table->string('medium')->nullable();
            $table->string('aff_vars')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('affiliate_campaign_datas');
    }
}
