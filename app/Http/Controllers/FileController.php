<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\ReservationRequest;
use App\Reservation;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nexmo\Response;
use ZanySoft\Zip\Zip;

class FileController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        if(Auth::user()->can('downloadZipToUsbFile', $file)) {
            return response()->download(storage_path(
                    'app/reservations/reservation_' .
                    $file->reservation()->first()->id .
                    '/filesToUsb.zip'
                )
            );
        }
    }

    public static function createFile(ReservationRequest $request, $reservationId){
        $file = new File();
        $file->nameOfCompressedFile = "";
        $file->save();
        $lastId = $file->id;

        $staticFolder       = 'reservations\reservation_' . $reservationId . '\\';
        $staticFolderTmp    = $staticFolder . 'tmp\\';

        $pathToZip          = 'app\\' . $staticFolder . 'filesToUsb.zip';

        $zip = Zip::create(storage_path($pathToZip));


        foreach ($request->file('files') as $uploadFile) {

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
