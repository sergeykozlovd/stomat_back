<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'category_id'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function adverts()
    {
        return $this
            ->belongsToMany(Advert::class, 'purchases', 'user_id', 'advert_id');
    }
}
