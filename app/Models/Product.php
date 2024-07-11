<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    protected $searchable = [
        'name',
        'description',
        'price',
        'categories.name',
    ];


    public function scopeSearch(Builder $builder, $term = '')
    {
        foreach ($this->searchable as $searchable) {
            if (str_contains($searchable, '.')) {
                $relation = Str::beforeLast($searchable, '.');
                $column = Str::afterLast($searchable, '.');
                $builder->orWhereRelation($relation, $column, 'like', "%$term%");
                continue;

            }

            $builder->orWhere($searchable, 'like', "%$term%");
        }
        return $builder;
    }


}
