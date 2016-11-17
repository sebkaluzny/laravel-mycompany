<?php

namespace App\Http\Controllers;

use App\Repositories\File\FileInterface;
use Illuminate\Http\Request;

use App\Http\Requests;

class FileController extends Controller
{

    /**
     * @var FileInterface
     */
    private $file;


    /**
     * FileController constructor.
     * @param FileInterface $file
     */
    public function __construct(FileInterface $file)
    {
        $this->file = $file;
    }

    private function getFile($id)
    {
        $get = $this->file->get($id);

        return $get;
    }

    public function getDownload($id)
    {
        $file = $this->getFile($id);

        if (strpos($file->name, '.') !== false) {
            return response()->download(storage_path('app/' . $file->path), $file->name);
        }

        return response()->download(storage_path('app/' . $file->path));
    }

    public function getPreview($id)
    {
        $file = $this->getFile($id);

        return response()->file(storage_path('app/' . $file->path));
    }
}
