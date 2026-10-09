<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_project_tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->date('deadline')->nullable();

            $table->enum('status', [
                'Belum',
                'On Progress',
                'Done',
            ])->default('Belum');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_project_tasks');
    }
};
