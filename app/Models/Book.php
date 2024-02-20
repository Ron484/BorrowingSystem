<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{

    const Available = 1;
    const Issued = 0;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'category_id', // Foreign key for the Category model
        'description',
        'pages',
        'status',
        'image',
        'created_at',

    ];

    use HasFactory;
    use SoftDeletes;

    public function scopeRecentlyAdded($query)
    {
        $query->orderBy('created_at', 'desc');
    }

    public static function mostBorrowed()
    {
        $subquery = DB::table('borrowing_books')
            ->select('book_id', DB::raw('COUNT(id) as borrow_count'))
            ->groupBy('book_id');

        $mostBorrowedBookIds = DB::table(DB::raw("({$subquery->toSql()}) as sub"))
            ->mergeBindings($subquery)
            ->orderByDesc('borrow_count')
            ->take(3)
            ->pluck('book_id');

        if ($mostBorrowedBookIds->isEmpty()) {
            return static::orderByDesc('created_at')->take(3)->get();
        }

        return static::whereIn('id', $mostBorrowedBookIds)->get();
    }

    public function getImage()
    {
        $isUrl = str_contains($this->image, 'http');

        return ($isUrl) ? $this->image : asset(Storage::url($this->image));
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowedBook()
    {
        return $this->hasOne(borrowingBooks::class);
    }

    public function requestedBook()
    {
        return $this->hasMany(borrow_requests::class);
    }

    public function isAvailable(): bool
    {
        return $this->status !== self::Issued;
    }
    public static function availableBooksCount()
    {
        return self::where('status', self::Available)->count();
    }
    public static function borrowedBooksCount()
    {
        $user = Auth::user();

        if ($user->role === 'ADMIN') {
            return BorrowingBooks::count();

        } else {
            return BorrowingBooks::where('user_id', $user->id)->distinct('book_id')->count();

        }
    }

}