<?php

namespace App\Helpers;

use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Str;

class RequestHelper
{
    public const REQUIRED_REQUEST_HEADER = 'request-id';
    public const SUCCESS_CODE = 20000;
    public const STATUS_SUCCESS = 'success';
    public const STATUS_ERROR = 'error';

    public const DISALLOW_METHOD_CODE = 40004;
    public const DISALLOW_METHOD_MESSAGE = 'Вызываемый метод не поддерживается';

    public const NOTEXIST_METHOD_CODE = 40001;
    public const NOTEXIST_METHOD_MESSAGE = 'Вызываемый метод отсутствует';

    public const BAD_TOKEN_CODE = 30001;
    public const BAD_TOKEN_MESSAGE = 'Неверный токен';

    public const USER_BLOCKED_CODE = 30002;
    public const USER_BLOCKED_MESSAGE = 'Пользователь заблокирован';

    public const BAD_REQUEST_CODE = 30003;

    /**
     * @param Request $request
     *
     * @return string
     */
    public static function getRequestId(Request $request): string
    {
        $requiredRequestHeader = env('REQUIRED_REQUEST_HEADER', self::REQUIRED_REQUEST_HEADER);
        $requestId = $request->header($requiredRequestHeader);
        if (empty($requestId)) {
            $requestId = Str::uuid()->toString();
            $request->headers->set($requiredRequestHeader, $requestId);
        }

        return $requestId;
    }

    /**
     * @param string $requestId
     * @param int $code
     * @param string $message
     * @param string $status
     *
     * @return JsonResponse
     */
    public static function getCustomErrorResponse(string $requestId, int $code, string $message, string $status = self::STATUS_ERROR): JsonResponse
    {
        return response()->json([
            'request_id' => $requestId,
            'status' => $status,
            'code' => $code,
            'error_message' => $message
        ]);
    }

    /**
     * @param string $requestId
     *
     * @return JsonResponse
     */
    public static function getDisallowMethodResponse(string $requestId): JsonResponse
    {
        return self::getCustomErrorResponse($requestId, self::DISALLOW_METHOD_CODE, self::DISALLOW_METHOD_MESSAGE);
    }

    /**
     * @param string $requestId
     *
     * @return JsonResponse
     */
    public static function getNotExistMethodResponse(string $requestId): JsonResponse
    {
        return self::getCustomErrorResponse($requestId, self::NOTEXIST_METHOD_CODE, self::NOTEXIST_METHOD_MESSAGE);
    }

    /**
     * @param string $requestId
     *
     * @return JsonResponse
     */
    public static function getBadTokenResponse(string $requestId): JsonResponse
    {
        return self::getCustomErrorResponse($requestId, self::BAD_TOKEN_CODE, self::BAD_TOKEN_MESSAGE);
    }

    /**
     * @param string $requestId
     *
     * @return JsonResponse
     */
    public static function getUserBlockedResponse(string $requestId): JsonResponse
    {
        return self::getCustomErrorResponse($requestId, self::USER_BLOCKED_CODE, self::USER_BLOCKED_MESSAGE);
    }

}
