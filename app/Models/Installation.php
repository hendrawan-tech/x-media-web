<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Installation extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['status', 'date_install', 'user_id'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'date_install' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
