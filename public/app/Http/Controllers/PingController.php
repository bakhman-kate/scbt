<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use Illuminate\Http\{JsonResponse, Request};

class PingController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if (!$request->isMethod('GET')) {
            return RequestHelper::getDisallowMethodResponse(RequestHelper::getRequestId($request));
        }

        return response()->json([
            'data' => ['message' => 'Сервис работает']
        ]);
    }

}
