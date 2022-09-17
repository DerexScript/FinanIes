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
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->string("description");
            $table->string("value");
            $table->date("date");
            $table->binary("voucher");
            $table->boolean("status");
            $table->unsignedBigInteger("company_id")->nullable();
            $table->unsignedBigInteger("category_id")->nullable();
            $table->foreign("company_id")->references("id")->on("companies");
            $table->foreign("category_id")->references("id")->on("categories");

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
        Schema::create('releases', function (Blueprint $table) {
            $table->dropForeign('releases_company_id_foreign');
            $table->dropForeign('releases_category_id_foreign');
        });
        Schema::dropIfExists('releases');
    }
};
