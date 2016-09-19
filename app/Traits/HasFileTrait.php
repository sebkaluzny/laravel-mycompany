<?php

namespace App\Traits;

use App\Models\File;

trait HasFileTrait
{

    public function files()
    {
        return $this->morphToMany(File::class, 'fileabble');
    }
}