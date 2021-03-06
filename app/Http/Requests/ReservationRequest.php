<?php

namespace App\Http\Requests;

use App\FileUpload;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'files' => 'nullable|max:'  . FileUpload::getMaxFileUploads(),
            'files.*' => 'file|max:'    . round(FileUpload::getPostMaxSize()/1000), //  "max:" validator waits for kilobytes value
            'reservation_name' => 'required',
            'number_keys' => 'required|min:1'
        ];
    }
}
