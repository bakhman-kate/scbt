<?php

namespace App\Http\Middleware;

use App\Helpers\RequestHelper;
use App\User;
use Closure;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\Log;

class ProcessingApiRequestMiddleware
{
    protected const ALLOWED_REQUEST_TYPES = 'GET, POST';
    protected const ALLOWED_REQUEST_URI = '/ping, /user/info, /user/create';

    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestId = RequestHelper::getRequestId($request);

        Log::info('API Request', [
            'headers' => $request->header(),
            'body' => $request->getContent(),
        ]);

        $allowedRequestTypes = explode(', ', env('ALLOWED_REQUEST_TYPES', self::ALLOWED_REQUEST_TYPES));
        if (!in_array($request->getMethod(), $allowedRequestTypes)) {
            return RequestHelper::getDisallowMethodResponse($requestId);
        }

        $allowedRequestUri = explode(', ', env('ALLOWED_REQUEST_URI', self::ALLOWED_REQUEST_URI));
        if (!in_array($request->getPathInfo(), $allowedRequestUri)) {
            return RequestHelper::getNotExistMethodResponse($requestId);
        }

        if ($request->getPathInfo() !== '/ping') {
            /**
             * @var User|null $user
             */
            $user = $request->user('api');
            if (empty($user)) {
                return RequestHelper::getBadTokenResponse($requestId);
            }

            if (!$user->getActive()) {
                return RequestHelper::getUserBlockedResponse($requestId);
            }
        }

        $response = $next($request);
        $this->formatResponseData($requestId, $response);

        return $response;
    }

    /**
     * @param Request $request
     * @param JsonResponse $response
     *
     * @return void
     */
    public function terminate(Request $request, JsonResponse $response): void
    {
        Log::info('API Response', [
            'response' => $response->getContent()
        ]);
    }

    /**
     * @param string $requestId
     * @param $response
     *
     * @return void
     */
    protected function formatResponseData(string $requestId, $response): void
    {
        $response->setData(array_merge(
            [
                'request_id' => $requestId,
                'status' => RequestHelper::STATUS_SUCCESS,
                'code' => RequestHelper::SUCCESS_CODE,
                'error_message' => '',
            ],
            $response->getData(true),
        ));
    }

}
