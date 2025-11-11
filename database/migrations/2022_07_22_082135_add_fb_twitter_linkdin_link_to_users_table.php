<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFbTwitterLinkdinLinkToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('users', function (Blueprint $table) {
            $table->text('fb')->nullable();
            $table->text('twitter')->nullable();
            $table->text('linkdin')->nullable();
            $table->text('instagram')->nullable();
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
            $table->dropColumn('fb');
            $table->dropColumn('twitter');
            $table->dropColumn('linkdin');
            $table->dropColumn('instagram');
        });
    }
}
