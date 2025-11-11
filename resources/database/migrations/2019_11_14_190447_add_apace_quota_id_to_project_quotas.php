<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApaceQuotaIdToProjectQuotas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_quotas', function (Blueprint $table) {
            $table->integer('apace_quota_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_quotas', function (Blueprint $table) {
            $table->dropColumn('apace_quota_id');
        });
    }
}
