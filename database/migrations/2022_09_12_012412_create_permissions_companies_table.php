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
        Schema::create('permission_company', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("permission_id");
            $table->unsignedBigInteger("company_id");
            $table->foreign("permission_id")->references("id")->on("permissions");
            $table->foreign("company_id")->references("id")->on("companies");
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
        Schema::create('permission_company', function (Blueprint $table) {
            $table->dropForeign('permission_company_permission_id_foreign');
            $table->dropForeign('permission_company_company_id_foreign');
        });
        Schema::dropIfExists('permission_company');
    }
};
