```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel riwayat perubahan status proyek akhir.
     */
    public function up(): void
    {
        Schema::create(
            'final_project_task_status_histories',
            function (Blueprint $table) {
                $table->id();

                // Relasi ke kegiatan proyek akhir
                $table->unsignedBigInteger('final_project_task_id');

                // Relasi ke pengguna yang melakukan perubahan
                $table->unsignedBigInteger('user_id')->nullable();

                // Riwayat status
                $table->string('from_status')->nullable();
                $table->string('to_status');
                $table->dateTime('changed_at')->useCurrent();

                $table->timestamps();

                // Foreign key kegiatan dengan nama pendek
                $table->foreign(
                    'final_project_task_id',
                    'fp_task_hist_task_id_fk'
                )
                ->references('id')
                ->on('final_project_tasks')
                ->cascadeOnDelete();

                // Foreign key pengguna dengan nama pendek
                $table->foreign(
                    'user_id',
                    'fp_task_hist_user_id_fk'
                )
                ->references('id')
                ->on('users')
                ->nullOnDelete();

                // Index gabungan dengan nama pendek
                $table->index(
                    ['final_project_task_id', 'changed_at'],
                    'fp_task_changed_at_idx'
                );
            }
        );
    }

    /**
     * Menghapus tabel riwayat jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists(
            'final_project_task_status_histories'
        );
    }
};