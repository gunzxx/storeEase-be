<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        if ($request->is('api/*')) {
            if ($exception instanceof ValidationException) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors' => $exception->errors()
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'Resource Not Found'
                ], Response::HTTP_NOT_FOUND);
            }

            // Handle other exceptions
            return response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return parent::render($request, $exception);
    }
}
