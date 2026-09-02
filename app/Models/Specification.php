<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_id',
        'detail',
        'body',
        'performa',
        'kelistrikan',
        'keselamatan',
        'fiturlainya'
    ];

    public $timestamps = false;

    protected $casts = [
        'body' => 'array',
        'performa' => 'array',
        'kelistrikan' => 'array',
        'keselamatan' => 'array',
        'fiturlainya' => 'array'
    ];

    public function model()
    {
        return $this->belongsTo(ModelList::class);
    }
}