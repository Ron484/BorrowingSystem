<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class borrow_requests extends Model
{

    const Waiting = 0;
    const Accepted = 1;
    const Rejected = 2;

    const type_request1 = 'Borrow';
    const type_request2 = 'Return';

    protected $fillable = [
        'user_id',
        'book_id',
        'due_date',
        'request_status',
        'type_request',
        'borrow_due_date',

    ];
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
    public static function getDueDate($bookId, $userId)
    {
        $request = self::where('book_id', $bookId)
            ->where('user_id', $userId)
            ->where('request_status', 1)
            ->latest()
            ->first();

        return $request ? $request->borrow_due_date : null;
    }
}