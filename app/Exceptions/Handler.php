<?php

namespace App\Exceptions;

use App\FlashMessage;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Illuminate\Http\Exceptions\PostTooLargeException) {
            FlashMessage::flash("personalized", $request,
                [
                    "message" => "La taille des données que vous envoyez est plus grande que celle autorisée par le serveur php (max_post_size). Veuillez contacter l'administrateur afin qu'il augmente cette valeur si besoin.",
                    "alertType" => "danger"
                ]
            );

            return redirect('reservation');
        }

        if ($exception instanceof \Symfony\Component\HttpFoundation\File\Exception\FileException) {
            FlashMessage::flash("personalized", $request,
                [
                    "message" => "File exception",
                    "alertType" => "danger"
                ]
            );
        }

        return parent::render($request, $exception);
    }
}
