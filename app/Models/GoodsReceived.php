<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TaxMachine\Models\FakturyKontrahent;

class GoodsReceived extends Model
{
    protected $table = 'goods_received';

    protected $fillable = ['number', 'company_id', 'received_at', 'company_id'];

    protected $dates = ['created_at', 'updated_at', 'received_at'];

    protected $appends = ['elements', 'received_at_date'];

    /**
     * Elements relationship
     *
     * @return $this
     */
    public function elements()
    {
        return $this->belongsToMany(Element::class, 'goods_received_element', 'goods_received_id', 'element_id')->withPivot('quantity');
    }

    /**
     * Company relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(FakturyKontrahent::class, 'company_id', 'dir_id');
    }

    /**
     * 'received_at_date' returns 'received_at' date string
     *
     * @return String
     */
    public function getReceivedAtDateAttribute()
    {
        return $this->received_at->toDateString();
    }


    public function getElementsAttribute()
    {
        return $this->elements()->get();
    }
}
