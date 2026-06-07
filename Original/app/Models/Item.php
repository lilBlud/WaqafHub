<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'location',
        'condition',
        'description',
        'images',
        'status',
        'type',
        'requested_by', 
    ];

    protected $casts = [
        'images' => 'array',
    ];

    // The person who donated the item
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The person who requested the item in the legacy single-request flow
    public function requestor()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function requests()
    {
        return $this->hasMany(ItemRequest::class);
    }

    public function latestRequest()
    {
        return $this->hasOne(ItemRequest::class)->latestOfMany();
    }
}