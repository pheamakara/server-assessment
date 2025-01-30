<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'server_id',
        'created_by',
        'status',
        'items',
        'comments'
    ];

    protected $casts = [
        'items' => 'array'
    ];

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
