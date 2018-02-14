<?php namespace App\Repositories;

use Illuminate\Support\Str;


class FilesRepository {

    public function saveOrUpdate($file, $element, $field, $path)
    {
        ini_set('memory_limit','512M');


        if (is_null($file) || !$file->isValid()) return;

        $destinationPath = storage_path($path);

        $oldFile = pathinfo($file->getClientOriginalName());
        //$fileName = strtolower(Str::slug($oldFile['filename'])) . time() . uniqid() . '.' . strtolower($file->getClientOriginalExtension());
        $fileName = strtolower(Str::slug($oldFile['filename'])) . 'u'.'u'. '.' . strtolower($file->getClientOriginalExtension());

        $file->move($destinationPath, $fileName);

        $element->{$field} = $fileName;

        $element->save();
    }


}