<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_name',
        'url_photo'
    ];

    public $timestamps = false;

    public function models()
    {
        return $this->hasMany(ModelList::class);
    }
}