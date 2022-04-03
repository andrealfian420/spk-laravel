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
    Schema::create('criteria_analysis_details', function (Blueprint $table) {
      $table->id();
      $table->foreignId('criteria_analysis_id')->constrained()->cascadeOnDelete();
      $table->unsignedBigInteger('criteria_id_first');
      $table->unsignedBigInteger('criteria_id_second');
      $table->decimal('comparison_value', 10, 9)->default(1);
      $table->decimal('comparison_result', 10, 9)->nullable();
      $table->timestamps();

      $table->foreign('criteria_id_first')->references('id')->on('criterias')->cascadeOnDelete();
      $table->foreign('criteria_id_second')->references('id')->on('criterias')->cascadeOnDelete();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('criteria_analysis_details');
  }
};
