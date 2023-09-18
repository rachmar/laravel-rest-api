<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{   
    /* The line `const SUCCESS_STATUS_CODE = [200, 201];` is declaring a constant variable named
    `SUCCESS_STATUS_CODE` with an array value of `[200, 201]`. This constant is used to define the
    HTTP status codes that are considered successful. In this case, the status codes 200 (OK) and
    201 (Created) are considered successful. */
    
    const SUCCESS_STATUS_CODE = [200, 201];

    /**
     * The function `successResponse` returns a JSON response with a success status, data, and a
     * message.
     * 
     * @param array data An array containing the data that you want to include in the response. This
     * can be any type of data, such as an array, object, or string.
     * @param string message The "message" parameter is a string that represents a message to be
     * included in the response. It can be used to provide additional information or instructions to
     * the client.
     * @param int statusCode The `statusCode` parameter is an optional parameter that specifies the
     * HTTP status code for the response. It defaults to 200, which means "OK". You can pass a
     * different status code if needed, such as 201 for "Created" or 400 for "Bad Request".
     * 
     * @return JsonResponse a JsonResponse object.
     */
    public function successResponse(array $data, int $statusCode = 200): JsonResponse
    {   
    	$response = [
            'data' => $data,
        ];

        return response()->json($response, $statusCode);
    }

    /**
     * The function `errorResponse` returns a JSON response with a status, message, and optional
     * additional errors, using the provided status code.
     * 
     * @param string message The "message" parameter is a string that represents the error message that
     * you want to include in the response. It should provide a clear and concise explanation of the
     * error that occurred.
     * @param int statusCode The `statusCode` parameter is an optional parameter that specifies the
     * HTTP status code to be returned in the response. By default, it is set to 404 (Not Found).
     * However, you can pass a different status code if needed.
     * @param array additionalErrors The `additionalErrors` parameter is an optional parameter that
     * allows you to pass an array of additional error messages or details. These additional errors
     * will be included in the response if the array is not empty.
     * 
     * @return JsonResponse a JsonResponse object.
     */
    public function errorResponse(string $message, int $statusCode = 404, array $additionalErrors = []): JsonResponse
    {   
    	$response = [
            'message' => $message,
        ];

        if(!empty($additionalErrors)){
            $response['errors'] = $additionalErrors;
        }
        
        return response()->json($response, $statusCode);
    }

}