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

        if ($data['success'] === false) {
            $responseStructure['error_code'] = 1;
        }
        return [ "content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers ];
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

}
