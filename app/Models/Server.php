<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
        'location',
        'type',
        'operating_system',
        'environment',
        'specifications',
        'stakeholders',
        'business_impact'
    ];

    protected $casts = [
        'specifications' => 'array',
        'stakeholders' => 'array'
    ];

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }
}
