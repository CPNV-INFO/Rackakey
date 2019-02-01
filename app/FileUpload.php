<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    static public function getPostMaxSize(){
        $actualMaxSize =  ini_get('post_max_size');

        if(preg_match('/(\d+)K/', $actualMaxSize, $matches)) // KiloBytes
            $inBytes = $matches[1] * pow(1024, 1);
        else if(preg_match('/(\d+)M/', $actualMaxSize, $matches)) // MegaBytes
            $inBytes = $matches[1] * pow(1024, 2);
        else if(preg_match('/(\d+)G/', $actualMaxSize, $matches)) // GigaBytes
            $inBytes = $matches[1] * pow(1024, 3);
        else  // It is certainly already in bytes ?
            $inBytes = $matches[0];

        return $inBytes;
    }

    static public function getMaxFileUploads(){
        $actualMaxFileUploadNumber =  ini_get('max_file_uploads');
        return $actualMaxFileUploadNumber;
    }
}
