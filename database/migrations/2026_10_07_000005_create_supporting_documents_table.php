<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up():void{Schema::create('supporting_documents',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->string('document_name');$t->text('description')->nullable();$t->date('deadline')->nullable();$t->string('status')->default('Belum');$t->timestamps();});} public function down():void{Schema::dropIfExists('supporting_documents');}};
