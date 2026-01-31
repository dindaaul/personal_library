<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('open_library_key')->nullable();
            $table->string('title');
            $table->string('author')->nullable();
            $table->integer('first_publish_year')->nullable();
            $table->string('cover_id')->nullable();
            $table->string('edition_key')->nullable(); // For reading access
            $table->text('personal_note')->nullable();
            $table->enum('reading_status', ['unread', 'reading', 'finished'])->default('unread');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
