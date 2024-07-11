<?php

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasJsonResponse
{
    /**
     * @param JsonResource|array $data
     * @param string $message
     * @param bool $success
     * @param int $code
     * @return JsonResponse
     */
    public function success( JsonResource|array $data = [] , string $message = 'core::response.success', bool $success = true, int $code = 200  ): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'code' => $code,
            'message' => trans($message),
            'data' => $data,
        ], $code);
    }

/**
 * @param string $message
 * @param array $data
 * @param int $code
 * @return JsonResponse
 */
public
function error(string $message = 'core::response.error', array $data = [], int $code = 400): JsonResponse
{
    return response()->json([
        'success' => false,
        'code' => $code,
        'message' => trans($message),
        'data' => $data
    ], $code);
}

/**
 * @param JsonResource|LengthAwarePaginator $paginator
 * @param string $message
 * @return JsonResponse
 */
public
function paginate(JsonResource|LengthAwarePaginator $paginator, string $message = 'Success'): JsonResponse
    {
        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => $message,
            'data' => $paginator,
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage()
            ],
        ]);
    }


    /*****************************basma pagination ****************/
    public
function paginateExtraData(JsonResource|LengthAwarePaginator $paginator): JsonResponse

    {
        return response()->json([
             'data' => $paginator,
            'pagination' => [
                'total' => $paginator->total(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage()
            ],
        ]);
    }

}
