<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementTask extends Model
{
    protected $table = 'element_tasks';

    protected $fillable = ['name', 'fields'];

    public function getFieldsAttribute($value) {
        return json_decode($value);
    }

    public function setFieldsAttribute($value)
    {
        $this->attributes['fields'] = json_encode($value);
    }
}
