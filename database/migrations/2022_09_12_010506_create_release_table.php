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
            $table->dateTimeTz("insert_date");
            $table->string("voucher");
            $table->boolean("status")->default(true);
            $table->unsignedBigInteger("category_id")->nullable();
            $table->unsignedBigInteger("release_group_id")->nullable();
            $table->foreign("category_id")->references("id")->on("categories");
            $table->foreign("release_group_id")->references("id")->on("releases_groups");
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
        Schema::table('releases', function (Blueprint $table) {
            $table->dropForeign('release_release_group_id_foreign');
            $table->dropForeign('release_category_id_foreign');
        });
        Schema::dropIfExists('release');
    }
};
