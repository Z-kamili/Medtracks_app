<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Support\Facades\Auth;


trait UploadTrait
{

    public function verifyAndStorageFile(Request $request, $inputname, $foldername, $disk, $fileable_id, $name)
    {

        if ($request->hasFile($inputname)) {

            //check file 
            if (!$request->file($inputname)->isValid()) {
                return redirect()->back()->with('error', 'ce email n\'exist pas');
            }

            $file = $request->file($inputname);
            $filename = $name . Auth::user()->id . '.' . $file->getClientOriginalExtension();
            //insert or update file
            $File = File::UpdateOrCreate(
                ['filename' => $filename],
                [
                    'filename' => $filename,
                    'fileable_id' => $fileable_id,
                ]
            );

            $request->file($inputname)->storeAs($foldername, $filename, $disk);
        }

        return null;
        
    }
}
