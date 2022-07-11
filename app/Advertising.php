<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Advertising extends Model
{
    protected $fillable = [
        'title', 'description', 'price'
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function getMainImageUrlAttribute()
    {
        return $this->images[0]->url ?? null;
    }

    /**
     * Скоуп для сортировки
     *
     * @param $query
     * @param array $fields
     * @return void
     */
    public function scopeSortByFields($query, array $fields)
    {
        $query->when(Arr::get($fields, 'price'), function ($q, $value) {
            $q->orderBy('price', $this->isCorrectSortDirection($value) ? $value : 'asc');
        });

        $query->when(Arr::get($fields, 'created_at'), function ($q, $value) {
            $q->orderBy('created_at', $this->isCorrectSortDirection($value) ? $value : 'asc');
        });
    }

    /**
     * Проверяет корректность направления сортировки
     *
     * @param string $direction
     * @return bool
     */
    private function isCorrectSortDirection(string $direction)
    {
        return in_array($direction, ['asc', 'desc']);
    }
}
