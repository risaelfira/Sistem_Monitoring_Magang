<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_project_task_status_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('final_project_task_id')
                ->constrained('final_project_tasks')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->dateTime('changed_at');

            $table->index([
                'final_project_task_id',
                'changed_at'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_project_task_status_histories');
    }
};
