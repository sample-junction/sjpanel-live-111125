<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPanellistIdAndIpRegisteredWithToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('panellist_id', 30)->nullable()->after('uuid');
            $table->string('ip_registered_with', 50)->nullable()->after('detailed_profile_filled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('panellist_id');
            $table->dropColumn('ip_registered_with');
        });
    }
}
