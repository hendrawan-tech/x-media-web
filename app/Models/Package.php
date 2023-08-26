<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['name', 'price', 'month', 'speed', 'description'];

    protected $searchableFields = ['*'];

    public function userMetas()
    {
        return $this->hasMany(UserMeta::class);
    }
}
