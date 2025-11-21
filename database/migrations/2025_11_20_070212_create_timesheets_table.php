<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id');      // user id
            $table->unsignedBigInteger('client_id');     // dropdown
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('break_minutes')->nullable();
            $table->decimal('total_hours', 5, 2)->default(0);
            $table->text('notes')->nullable();
            $table->string('admin_notes')->nullable();
            $table->string('locked')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheets');
    }
};
