<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class borrowingBooks extends Model
{

    protected $fillable = [
        'borrowed_at',
        'returned_at',
        'return_state',
        'user_id', // Foreign key for the User model
        'book_id', // Foreign key for the Category model

    ];
    public $timestamps = false;

    protected $casts = [
        'borrowed_at' => 'datetime',
        'returned_at' => 'datetime',

    ];
    use HasFactory;

    public function scopeLatestBorrowed($query)
    {
        $query->orderBy('borrowed_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public static function returnedBooksCount()
    {
        $user = Auth::user();

        if ($user->role === 'ADMIN') {
            return self::where('return_state', true)->count();
        }

        return self::where('user_id', $user->id)->where('return_state', true)->count();

    }

}