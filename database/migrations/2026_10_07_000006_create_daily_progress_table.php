<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up():void{Schema::create('daily_progress',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->date('date');$t->string('short_description');$t->longText('detailed_description');$t->string('screenshot_path')->nullable();$t->timestamps();});} public function down():void{Schema::dropIfExists('daily_progress');}};
