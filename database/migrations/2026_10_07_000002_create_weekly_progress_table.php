<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up():void{Schema::create('weekly_progress',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->unsignedInteger('week_number');$t->date('start_date');$t->date('end_date');$t->text('activities');$t->text('insights');$t->text('tasks');$t->timestamps();});} public function down():void{Schema::dropIfExists('weekly_progress');}};
