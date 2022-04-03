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
    Schema::create('preventive_values', function (Blueprint $table) {
      $table->id();
      $table->foreignId('criteria_analysis_id')->constrained()->cascadeOnDelete();
      $table->foreignId('criteria_id')->constrained()->cascadeOnDelete();
      $table->decimal('value', 10, 9);
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
    Schema::dropIfExists('preventive_values');
  }
};
