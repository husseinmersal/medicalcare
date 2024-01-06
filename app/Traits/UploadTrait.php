<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadTrait{

    public function verifyAndStoreImage(Request $request, $inputname , $foldername , $disk, $imageable_id, $imageable_type) {

        if( $request->hasFile( $inputname ) ) {

            // Check img
            if (!$request->file($inputname)->isValid()) {
                $this->flash('Invalid Image!')->error()->important();
                return redirect()->back()->withInput();
            }

            $photo = $request->file($inputname);
            $name = \Str::slug($request->input('name'));
            $file_name = $name. '.' . $photo->getClientOriginalExtension();


            // insert Image
            $Image = new Image();
            $Image->file_name = $file_name;
            $Image->imageable_id = $imageable_id;
            $Image->imageable_type = $imageable_type;
            $Image->save();
            return $request->file($inputname)->storeAs($foldername, $file_name, $disk);

        }

        return null;

    }



    public function delete_attachment($disk,$path,$id,$file_name){
        Storage::disk($disk)->delete($path);
        Image::where('id',$id)->where('file_name',$file_name)->delete();
    }




}