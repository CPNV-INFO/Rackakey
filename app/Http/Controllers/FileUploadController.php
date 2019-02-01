<?php

namespace App\Http\Controllers;

use App\FileUpload;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{

    public function getMaxFileUploads(){
        $maxFileUploads = ["max_file_uploads" => FileUpload::getMaxFileUploads()];
        return json_encode($maxFileUploads);
    }

    public function getPostMaxSize(){
        $postMaxSize = ["post_max_size" => FileUpload::getPostMaxSize()];
        return json_encode($postMaxSize);
    }
}
