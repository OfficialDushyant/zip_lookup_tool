<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lookups extends Model
{
    use HasFactory;

    protected $table = 'lookups';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'zip',
        'valid_response',
        'data',
    ];

    public function user()
    {
        $this->belongsTo(User::class, 'user_id', 'id');
    }
}
