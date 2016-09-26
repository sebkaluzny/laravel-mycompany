<?php

namespace App\Models;

use App\Traits\HasFileTrait;
use Illuminate\Database\Eloquent\Model;

class Element extends Model
{

    use HasFileTrait;

    protected $table = 'elements';

    protected $fillable = ['name', 'thickness', 'width', 'length', 'note', 'done_quantity', 'project_id', 'quantity', 'making'];

//    protected $appends = ['history'];

    public function goodsReceived()
    {
        return $this->belongsToMany(GoodsReceived::class, 'goods_received_element', 'element_id',
            'goods_received_id')->withPivot('quantity');
    }

    public function tasks()
    {
        return $this->belongsToMany(ElementTask::class, 'element_task', 'element_id',
            'task_id')->withPivot('quantity', 'fields');
    }

    public function getFilesAttribute()
    {
        return $this->files()->get();
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
