<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Book;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowing_books', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Book::class);
            $table->timestamp('borrowed_at')->useCurrent(); 
            $table->timestamp('returned_at')->nullable(); // The date and time when the book was returned (null if not returned yet).
            $table->timestamp('due_date')->nullable(); // The date when the borrowed book is expected to be returned.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowing_books');
    }
};
