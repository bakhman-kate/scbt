<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Services\UserServiceInterface;
use App\User;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * Instantiate a new controller instance
     *
     * @return void
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the authorized user
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        if (!$request->isMethod('GET')) {
            return RequestHelper::getDisallowMethodResponse(RequestHelper::getRequestId($request));
        }

        $data = [];
        /**
         * @var User|null $user
         */
        if ($user = $request->user()) {
            $data = $this->userService->getData($user);
        }

        return response()->json(['data' => $data]);
    }

    /**
     * Store a newly created user
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        if (!$request->isMethod('POST')) {
            return RequestHelper::getDisallowMethodResponse(RequestHelper::getRequestId($request));
        }

        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'bd' => 'nullable|date_format:'.env('DEFAULT_DATE_FORMAT', 'Y-m-d H:i:s')
        ]);

        if ($validator->fails()) {
            return RequestHelper::getCustomErrorResponse(
                RequestHelper::getRequestId($request),
                RequestHelper::BAD_REQUEST_CODE,
                json_encode(['errors' => $validator->errors()])
            );
        }

        $data = [];
        if ($this->userService->create($this->getValidatedData($request, $validator))) {
            $data['message'] = 'Пользователь успешно создан';
        }

        return response()->json(['data' => $data]);
    }

    /**
     * @param Request $request
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @return array
     */
    protected function getValidatedData(Request $request, \Illuminate\Contracts\Validation\Validator $validator): array
    {
        $validated = $validator->validated();
        $fio = trim($request->input('last_name') . ' ' . $request->input('name') . ' ' . $request->input('middle_name', ''));
        $validated['access_token'] = md5(trim($fio . $request->input('bd', date(env('DEFAULT_DATE_FORMAT', 'Y-m-d H:i:s')))));

        return $validated;
    }

}
