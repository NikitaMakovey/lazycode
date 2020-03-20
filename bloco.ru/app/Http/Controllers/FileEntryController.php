<?php

namespace App\Http\Controllers;

use App\FileEntry;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Input\Input;

class FileEntryController extends Controller
{
    public function uploadFile(Request $request)
    {
        $file = Input::file('file');
        $filename = $file->getClientOriginalName();
        $path = Hash::make(time());

        if (
            Storage::disk('uploads')
                ->put($path.'/'.$filename, File::get($file))
        ) {
            $input['filename'] = $filename;
            $input['mime'] = $file->getClientMimeType();
            $input['path'] = $path;
            $input['size'] = $file->getClientSize();
            $file = FileEntry::create($input);

            return response(array(
                'url' =>
                    'http://lazy.codes/storage/files/uploads/'.$path.'/'.$filename,
                'success' => true,
                'id' => $file->id
            ), 200);
        }

        return response(array(
            'success' => false
        ), 500);
    }
}
