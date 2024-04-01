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
        if ($e instanceof PostTooLargeException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => "Size of attached file should be less " . ini_get("upload_max_filesize") . "B",
                ],
                400
            );
        }
        if ($e instanceof AuthenticationException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => 'Unauthenticated or Token Expired, Please Login',
                ],
                401
            );
        }
        if ($e instanceof AuthorizationException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => 'You are not authorized to perform to this action',
                ],
                403
            );
        }
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

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => 'This method is not allowed, refer to docs',
                ], 405);
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
        if ($e instanceof ThrottleRequestsException) {
            return $this->apiResponse(
                [
                    'success' => false,
                    'message' => 'Too Many Requests,Please Slow Down',
                ],
                429
            );
        }
        if ($e instanceof QueryException) {
            return $this->apiResponse(
                [
                    'success'   => false,
                    'message'   => 'There was Issue with the Query',
                    'exception' => $e,

                ],
                500
            );
        }
        if ($e instanceof HttpResponseException) {
            return $this->apiResponse(
                [
                    'success'   => false,
                    'message'   => "There was some internal error",
                    'exception' => $e,
                ],
                500
            );
        }
        if ($e instanceof \Error) {
            return $this->apiResponse(
                [
                    'success'   => false,
                    'message'   => "There was some internal error",
                    'exception' => $e,
                ],
                500
            );
        }
        return parent::render($request, $e);
    }
}
