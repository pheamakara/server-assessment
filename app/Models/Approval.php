<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'approver_id',
        'type',
        'status',
        'comments'
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
