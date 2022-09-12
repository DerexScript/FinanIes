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
        Schema::create('permission_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("permission_id");
            $table->unsignedBigInteger("category_id");
            $table->foreign("permission_id")->references("id")->on("permissions");
            $table->foreign("category_id")->references("id")->on("releases");
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
        Schema::create('permission_category', function (Blueprint $table) {
            $table->dropForeign('permission_category_permission_id_foreign');
            $table->dropForeign('permission_category_category_id_foreign');
        });
        Schema::dropIfExists('permission_category');
    }
};
