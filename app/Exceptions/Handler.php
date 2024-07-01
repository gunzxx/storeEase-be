<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'error' => 'Method Not Allowed',
                'message' => " HTTP method:" . $request->method() . " untuk route ini tidak diizinkan",
                'status' => 405
            ], 405);
        }

        // Handle HTTP Exceptions
        if ($exception instanceof HttpException) {
            $statusCode = $exception->getStatusCode();
            return response()->json([
                'message' => 'Error occurred',
                'status_code' => $statusCode
            ], $statusCode);
        }

        // Handle other exceptions
        if ($this->isHttpException($exception)) {
            return $this->renderHttpException($exception);
        } else {
            // Log exception
            logger()->error($exception);
            // Generic error message and 500 status code
            return response()->json([
                'message' => $exception->getMessage(),
                'status_code' => 500
            ], 500);
        }

        return parent::render($request, $exception);
    }
}
