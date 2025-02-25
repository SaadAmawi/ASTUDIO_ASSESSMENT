<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
{
    Schema::create('attribute_values', function (Blueprint $table) {
        $table->id();
        $table->foreignId('attribute_id')->constrained()->onDelete('cascade');
        $table->foreignId('entity_id'); 
        $table->string('entity_type'); 
        $table->text('value');
        $table->timestamps();
    });
}
    

  
    public function down(): void
    {
        Schema::dropIfExists('attribute_values');
    }
};
