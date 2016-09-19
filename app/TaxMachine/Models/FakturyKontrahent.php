<?php


namespace TaxMachine\Models;


use Illuminate\Database\Eloquent\Model;

class FakturyKontrahent extends Model
{
    protected $connection = 'taxmachine';

    protected $table = 't_faktury_kontrahent';

    public $timestamps = false;

    protected $primaryKey = 'dir_id';

    protected $appends = ['name', 'post_city', 'street', 'post_number', 'city', 'country'];

    public function getNameAttribute()
    {
        return $this->nazwa;
    }

    public function getStreetAttribute()
    {
        return "{$this->ulica} {$this->dom}" . ($this->lokal != '' ? "/{$this->lokal}" : '');
    }

    public function getCityAttribute()
    {
        return $this->miejscowosc;
    }

    public function getPostNumberAttribute()
    {
        return $this->kod;
    }

    public function getPostCityAttribute()
    {
        return ($this->poczta == '' ? $this->miejscowosc : $this->poczta);
    }

    public function getCountryAttribute()
    {
        return $this->kraj;
    }
}