<?php

namespace App\Http\Traits;

use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use JetBrains\PhpStorm\ArrayShape;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait ApiResponseTrait
{
    /**
     * @param JsonResource $resource
     * @param null         $message
     * @param int          $statusCode
     * @param array        $headers
     *
     * @return JsonResponse
     */
    protected function respondWithResource(JsonResource $resource, $message = null, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => true,
                'data'    => $resource,
                'message' => $message,
            ], $statusCode, $headers
        );
    }

    /**
     * @param array $data
     * @param int   $statusCode
     * @param array $headers
     *
     * @return array
     */
    #[ArrayShape( [ "content" => "array", "statusCode" => "int|mixed", "headers" => "array" ] )]
    public function parseGivenData(array $data = [], int $statusCode = 200, array $headers = []): array
    {
        $responseStructure = [
            'success' => $data['success'],
            'message' => $data['message'] ?? null,
            'data'    => $data['data'] ?? null,
        ];
        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }
        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }


        if (isset($data['exception']) && ( $data['exception'] instanceof Error || $data['exception'] instanceof Exception )) {
            if (config('app.env') !== 'production') {
                $responseStructure['exception'] = [
                    'message' => $data['exception']->getMessage(),
                    'file'    => $data['exception']->getFile(),
                    'line'    => $data['exception']->getLine(),
                    'code'    => $data['exception']->getCode(),
                    'trace'   => $data['exception']->getTrace(),
                ];
            }

            if ($statusCode === 200) {
                $statusCode = 500;
            }
        }
        if ($data['success'] === false) {
            if (isset($data['error_code'])) {
                $responseStructure['error_code'] = $data['error_code'];
            } else {
                $responseStructure['error_code'] = 1;
            }
        }
        return [ "content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers ];
    }


    public function respondWithCompressedResponse(string $data, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return response()->json(
            [
                'success' => true,
                'message' => null,
                'data'    => $data,
            ],
            $statusCode,
            $headers
        );
    }

    /**
     * Return generic json response with the given data.
     *
     * @param array $data
     * @param int   $statusCode
     * @param array $headers
     *
     * @return JsonResponse
     */
    protected function apiResponse(array $data = [], int $statusCode = 200, array $headers = []): JsonResponse
    {
        $result = $this->parseGivenData($data, $statusCode, $headers);
        return response()->json(
            $result['content'], $result['statusCode'], $result['headers']
        );
    }

    /*
     *
     * Just a wrapper to facilitate abstract
     */

    /**
     * @param ResourceCollection $resourceCollection
     * @param null               $message
     * @param int                $statusCode
     * @param array              $headers
     *
     * @return JsonResponse
     */
    protected function respondWithResourceCollection(ResourceCollection $resourceCollection, $message = null, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => true,
                'data'    => $resourceCollection->response()->getData(true),
                'message' => $message,
            ], $statusCode, $headers
        );
    }

    protected function respondWithArray(array $data, int $statusCode = 200, array $headers = []): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => true,
                'data'    => $data,

            ], $statusCode, $headers
        );
    }

    /**
     * Respond with success.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondSuccess(string $message = ''): JsonResponse
    {
        return $this->apiResponse([ 'success' => true, 'message' => $message ]);
    }

    /**
     * Respond with created.
     *
     * @param $data
     *
     * @return JsonResponse
     */
    protected function respondCreated($data): JsonResponse
    {
        return $this->apiResponse($data, 201);
    }

    /**
     * Respond with no content.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondNoContent(string $message = 'No Content Found'): JsonResponse
    {
        return $this->apiResponse([ 'success' => false, 'message' => $message ], 200);
    }


    /**
     * Respond with unauthorized.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondUnAuthorized(string $message = 'You are not authorized to perform this action'): JsonResponse
    {
        return $this->respondError($message, 403);
    }

    /**
     * Respond with unauthorized.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondUnAuthenticated(string $message = 'Please provide a valid token to authenticate'): JsonResponse
    {
        return $this->respondError($message, 401);
    }

    /**
     * Respond with error.
     *
     * @param                $message
     * @param int            $statusCode
     *
     * @param Exception|null $exception
     * @param int            $error_code
     *
     * @return JsonResponse
     */
    protected function respondError($message, int $statusCode = 400, Exception $exception = null, int $error_code = 1): JsonResponse
    {
        return $this->apiResponse([ 'success' => false, 'message' => $message, ], $statusCode);
    }

    /**
     * Respond with forbidden.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondForbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->respondError($message, 403);
    }

    /**
     * Respond with not found.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondNotFound(string $message = 'Not Found'): JsonResponse
    {
        return $this->respondError($message, 404);
    }

    /**
     * Respond with failed login.
     *
     * @return JsonResponse
     */
    protected function respondFailedLogin(): JsonResponse
    {
        return $this->apiResponse([ 'success' => false, 'message' => 'Email or password is invalid' ], 422);
    }

    /**
     * Respond with internal error.
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function respondInternalError(string $message = 'Internal Error'): JsonResponse
    {
        return $this->respondError($message, 500);
    }

    protected function respondValidationErrors(ValidationException $exception): JsonResponse
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $exception->getMessage(),
                'errors'  => $exception->errors(),
            ],
            422
        );
    }
}
