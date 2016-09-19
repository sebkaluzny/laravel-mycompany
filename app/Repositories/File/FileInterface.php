<?php


namespace App\Repositories\File;


use Illuminate\Http\Request;

interface FileInterface
{

    public function search(array $input = []);

    public function create(Request $request);
}