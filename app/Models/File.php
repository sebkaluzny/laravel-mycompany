<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class File extends Model
{
//    protected $table = 'files';

    protected $fillable = ['name', 'path'];

    protected $appends = ['download_url', 'preview_url'];

    public function getDownloadUrlAttribute($val)
    {
        return action('FileController@getDownload', $this->id);
    }

    public function getPreviewUrlAttribute($val)
    {
        return action('FileController@getPreview', $this->id);
    }
}
