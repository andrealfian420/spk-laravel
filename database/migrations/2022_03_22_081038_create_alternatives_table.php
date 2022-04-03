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
    Schema::create('alternatives', function (Blueprint $table) {
      $table->id();
      $table->foreignId('criteria_id')->constrained()->cascadeOnDelete();
      $table->foreignId('tourism_object_id')->constrained()->cascadeOnDelete();
      $table->decimal('alternative_value', 10, 1);
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
    Schema::dropIfExists('alternatives');
  }
};
