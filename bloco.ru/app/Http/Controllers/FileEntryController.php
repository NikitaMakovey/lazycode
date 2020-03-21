<?php

namespace App\Http\Controllers;

use App\FileEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileEntryController extends Controller
{
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
        $fn = $request->file('file')->getClientOriginalName();
        $encode_fn = Str::slug($fn, "_");
        $filename = $this->stringFileName($encode_fn);

        $path = str_replace("/", "_", Hash::make(time()));

        //return response([$file], 200);

        if (Storage::disk('local')->put($path.'/'.$filename, File::get($file))) {


            $input['filename'] = $filename;
            $input['mime'] = $request->file('file')->getClientMimeType();
            $input['path'] = $path;
            $input['size'] = $request->file('file')->getClientSize();
            $file = FileEntry::create($input);

            $url = 'http://localhost:8000';

            return response(array(
                'url' =>
                    $url.'/uploads/'.$path.'/'.$filename,
                'success' => true,
                'id' => $file->id
            ), 200);
        }

        return response(array(
            'success' => false
        ), 500);
    }

    private function stringFileName(string $str)
    {
        $str_length = mb_strwidth($str);
        $formats = array("jpeg", "jpg", "png");
        foreach ($formats as $format) {
            $pos = strrpos($str, $format, -1);
            if ($pos && $pos == $str_length - mb_strwidth($format)) {
                $str_ = substr_replace($str, chr(46), $pos, 0);
                return $str_;
            }
        }
        return -1;
    }
}
