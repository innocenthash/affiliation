<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('identifiant_users', function (Blueprint $table) {
            //
            $table->mediumText('url')->default('http');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('identifiant_users', function (Blueprint $table) {
            //
            $table->dropColumn('url');
        });
    }
};
