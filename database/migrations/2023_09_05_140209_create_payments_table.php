<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->integer('status');
            $table->bigInteger('price',false,true);
            $table->string('shaba');
            $table->text('description')->nullable();
            $table->text('attachment')->nullable();
            $table->timestamps();
        });
    }
};
