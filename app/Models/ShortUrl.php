<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    public $table = 'short_urls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'long_url',
        'short_url',
        'hits',
        'created_by'
    ];

    /**
     * Define relationship with the User model
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
