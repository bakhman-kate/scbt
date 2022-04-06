<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * Instantiate a new controller instance
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the authorized user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $request->user();

        return response()->json($this->userService->getData($user));
    }

    /**
     * Store a newly created user
     *
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $fio = trim($request->input('last_name') . $request->input('name') . $request->input('middle_name'));
        $validated['token'] = md5(trim($fio . $request->input('bd')));

        $data = [];
        $user = $this->userService->create($validated);
        if ($user) {
            $data['message'] = 'Пользователь успешно создан';
        }

        return response()->json($data);
    }

}
