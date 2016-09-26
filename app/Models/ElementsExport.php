<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElementsExport extends Model
{
    protected $table = 'elements_export';

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value);
    }

    public function getExportDataAttribute($value)
    {
        return json_decode($value);
    }

    public function setExportDataAttribute($value)
    {
        $this->attributes['export_data'] = json_encode($value);
    }
}
