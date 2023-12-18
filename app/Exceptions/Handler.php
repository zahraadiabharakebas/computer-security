<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface; // Add this import
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // You can add custom logic here for reporting exceptions
        });
    }

//    public function render($request, Throwable $exception)
//    {
//        if ($this->isHttpException($exception)) {
//            return $this->renderHttpException($exception);
//        }
//
//        return parent::render($request, $exception);
//    }

//    protected function renderHttpException(HttpExceptionInterface $e)
//    {
//        view()->addNamespace('errors', resource_path('C:/Laravel Workspace/computer-security/resources/views/404.blade.php'));
//
//        $status = $e->getStatusCode();
//
//        if (view()->exists("errors.$status")) {
//            return response()->view("errors.$status", ['exception' => $e], $status);
//        } else {
//            return $this->convertExceptionToResponse($e); // This assumes you have a method named convertExceptionToResponse
//        }
//    }
}
