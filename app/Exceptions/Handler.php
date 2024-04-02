<?php

namespace App\Exceptions;

use App\Http\Traits\ApiResponseTrait;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait;
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

    public function render($request, Throwable $e): Response
    {
        if ($e instanceof ModelNotFoundException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => 'Can not find data with provided parameters',
                ],
                404
            );
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => 'Provided arguments not found',
                ],
                404
            );
        }

        if ($e instanceof RouteNotFoundException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => 'Provided route not found',
                ], 404);
        }

        if ($e instanceof ValidationException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors'  => $e->errors(),
                ],
                422
            );
        }

        return parent::render($request, $e);
    }
}
