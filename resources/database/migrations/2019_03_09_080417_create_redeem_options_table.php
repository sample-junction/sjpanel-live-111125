<<<<<<< HEAD
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedeemOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('redeem_options')) {
            Schema::create('redeem_options', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string("display_name")->nullable();
                $table->string('code')->nullable();
                $table->string('image_uri')->nullable();

                $table->integer('country_id')->nullable()->unsigned();
                $table->string('country_code', 3)->nullable();
                $table->string('country_display_name', 100)->nullable();

                $table->string('type', 100)->default('giftcard');
                $table->string('status', 10)->default('active');
                $table->integer('order')->default(10);

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
        Schema::dropIfExists('redeem_options');
    }
}
=======
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRedeemOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('redeem_options')) {
            Schema::create('redeem_options', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string("display_name")->nullable();
                $table->string('code')->nullable();
                $table->string('image_uri')->nullable();

                $table->integer('country_id')->nullable()->unsigned();
                $table->string('country_code', 3)->nullable();
                $table->string('country_display_name', 100)->nullable();

                $table->string('type', 100)->default('giftcard');
                $table->string('status', 10)->default('active');
                $table->integer('order')->default(10);

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
        Schema::dropIfExists('redeem_options');
    }
}
>>>>>>> dev
