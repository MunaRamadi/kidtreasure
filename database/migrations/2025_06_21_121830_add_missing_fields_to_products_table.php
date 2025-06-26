<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->text('features')->nullable();
        $table->text('components')->nullable();
        $table->text('skills_developed')->nullable();
        $table->string('material')->nullable();
        $table->string('dimensions')->nullable();
    });
}

public function down()
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['features', 'components', 'skills_developed', 'material', 'dimensions']);
    });
}
};
