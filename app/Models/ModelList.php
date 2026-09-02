<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Type;
use App\Models\Specification;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelList extends Model
{
    use HasFactory;

    protected $table = 'models';

    protected $fillable = [
        'brand_id',
        'type_id',
        'model_name',
        'url_photo'
    ];

    public $timestamps = false;

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function specification()
    {
        return $this->hasOne(Specification::class, 'model_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'model_id', 'id');
    }
}
