<<<<<<< HEAD
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestRedeemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_redeems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_uuid');
            $table->integer('total_points');
            $table->integer('redeem_points');
            $table->string('redeem_method');
            $table->timestamp('approve')->nullable();
            $table->timestamp('coupon_sent')->nullable();
            $table->timestamp('ribbon_notified')->nullable();
            $table->timestamp('coupon_redeemed')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('request_redeems');
    }
}
=======
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestRedeemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_redeems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_uuid');
            $table->integer('total_points');
            $table->integer('redeem_points');
            $table->string('redeem_method');
            $table->timestamp('approve')->nullable();
            $table->timestamp('coupon_sent')->nullable();
            $table->timestamp('ribbon_notified')->nullable();
            $table->timestamp('coupon_redeemed')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('request_redeems');
    }
}
>>>>>>> dev
