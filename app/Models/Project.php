<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = ['name'];

    protected $appends = ['elements_count'];

    public function elements() {
        return $this->hasMany(Element::class);
    }

    public function getElementsCountAttribute($val)
    {
        return $this->elements()->get()->count();
    }
}
