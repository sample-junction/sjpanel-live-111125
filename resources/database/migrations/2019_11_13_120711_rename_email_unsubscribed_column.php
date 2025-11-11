<<<<<<< HEAD
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEmailUnsubscribedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('users', 'unsubscribed') == 0)
        {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('email_unsubscribed', 'unsubscribed');
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
        if(Schema::hasColumn('users', 'email_unsubscribed') == 0)
        {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('unsubscribed', 'email_unsubscribed');
            });
        }
    }
}
=======
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEmailUnsubscribedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('users', 'unsubscribed') == 0)
        {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('email_unsubscribed', 'unsubscribed');
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
        if(Schema::hasColumn('users', 'email_unsubscribed') == 0)
        {
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('unsubscribed', 'email_unsubscribed');
            });
        }
    }
}
>>>>>>> dev
