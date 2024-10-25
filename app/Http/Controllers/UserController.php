<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    private UserServiceInterface $userService;

    /**
     * UserController constructor.
     * 
     * @param UserServiceInterface $userService
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();

        return [
            'status' => 200,
            'message' => 'Usuários encontrados!',
            'users' => $users
        ];
    }

    /**
     * Show the authenticated user.
     */
    public function me()
    {
        $user = $this->userService->getAuthenticatedUser();

        return [
            'status' => 200,
            'message' => 'Usuário logado!',
            'user' => $user
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        return [
            'status' => 200,
            'message' => 'Usuário cadastrado com sucesso!',
            'user' => $user
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado!',
                'user' => null
            ];
        }

        return [
            'status' => 200,
            'message' => 'Usuário encontrado com sucesso!',
            'user' => $user
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $updatedUser = $this->userService->updateUser($id, $request->validated());

        if (!$updatedUser) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado!',
                'user' => null
            ];
        }

        return [
            'status' => 200,
            'message' => 'Usuário atualizado com sucesso!',
            'user' => $updatedUser
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return [
                'status' => 404,
                'message' => 'Usuário não encontrado!'
            ];
        }

        return [
            'status' => 200,
            'message' => 'Usuário deletado com sucesso!'
        ];
    }
}
