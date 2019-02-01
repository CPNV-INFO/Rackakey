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
        $file->numberOfFiles = 0;
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

        $file->nameOfCompressedFile = $pathToZip;
        $file->numberOfFiles = count($zip->listFiles());
        $file->update();

        $zip->close();

        return $lastId;
    }

    public function showFilesList(Request $request, $id){

        $reservationId = File::with('reservation')->where('id', $id)->first()->reservation->id;

        $zip = Zip::open(
            storage_path(
                File::with('reservation')
                    ->where('id', $id)->first()
                    ->nameOfCompressedFile
            )
        );

        $filesList = $zip->listFiles();

        $zip->close();

        return view("filesList")->with("filesList", $filesList);
    }
}
