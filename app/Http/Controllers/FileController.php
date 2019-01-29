<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\ReservationRequest;
use App\Reservation;
use Illuminate\Http\Request;
use ZanySoft\Zip\Zip;

class FileController extends Controller
{

    public static function createFile(ReservationRequest $request){
        $file = new File();
        $file->nameOfCompressedFile = "";
        $file->save();

        $lastId = $file->id;

        $staticFolder       = 'reservations\reservation_' . $lastId . '\\';
        $staticFolderTmp    = $staticFolder . 'tmp\\';

        $pathToZip          = 'app\\' . $staticFolder . 'filesToUsb.zip';

        $zip = Zip::create(storage_path($pathToZip));

        foreach($request->file('files') as $uploadFile){

            $pathToFile = $staticFolderTmp . $uploadFile->getClientOriginalName();
            $uploadFile->storeAs($staticFolderTmp, $uploadFile->getClientOriginalName());

            $zip->add(storage_path('app\\' . $pathToFile));
        }

        $zip->close();

        $file->nameOfCompressedFile = $pathToZip;
        $file->update();

        return $lastId;
    }
}
