<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'url_logo'
    ];

    public $timestamps = false;

    public function models()
    {
        return $this->hasMany(ModelList::class);
    }
}