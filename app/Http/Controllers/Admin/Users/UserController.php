<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Request;

class UserController extends Controller
{
    public function index()
    {
        $sql = "SELECT users.*, GROUP_CONCAT(roles.name) as roles, GROUP_CONCAT(permissions.name) as permissions
                FROM users
                LEFT JOIN role_user ON users.id = role_user.user_id
                LEFT JOIN roles ON role_user.role_id = roles.id
                LEFT JOIN permission_user ON users.id = permission_user.user_id
                LEFT JOIN permissions ON permission_user.permission_id = permissions.id
                GROUP BY users.id
                ";
        $users = (new User())->query($sql);

        return view('admin.users.index', compact('users'));
    }

    public function show(int $userId)
    {

    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255',
                'email' => 'required|email||max:255|unique:users,email',
                'password' => 'required|min:6||max:255',
                'confirm_password' => 'required|same:password',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/users/create');
        }

        $validatedData = $validation->getValidatedData();
        unset($validatedData['confirm_password']);

        (new User())->create([
            ...$validatedData,
            'password' => password_hash($validatedData['password'], PASSWORD_DEFAULT)
        ]);

        return redirect('/admin-panel/users');
    }

    public function edit(int $userId)
    {
        $user = (new User())->find($userId);

        return view('admin.users.edit', compact('user'));
    }

    public function update()
    {
        if (request()->has('user_id')) {
            $userId = request()->input('user_id');
            $user = (new User())->find($userId);
            $validation = $this->validate(
                request()->all(),
                [
                    'user_id' => 'required|numeric|exists:users,id',
                    'name' => 'required|min:3|max:255',
                    'email' => 'required|email|max:255|unique:users,email,' . $user->email,
                    'password' => 'min:6|max:255',
                    'confirm_password' => 'same:password',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/users/edit/' . $userId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedUserId = $validatedData['user_id'];
            unset($validatedData['confirm_password']);
            unset($validatedData['user_id']);


            if (empty($validatedData['password'])) {
                unset($validatedData['password']);
            } else {
                $validatedData['password'] = password_hash($validatedData['password'], PASSWORD_DEFAULT);
            }

            (new User())->update($validatedUserId, [...$validatedData]);

            return redirect('/admin-panel/users');
        }

        return redirect('/admin-panel/users');
    }

    public function delete()
    {
        if (request()->has('user_id')) {
            $userId = request()->input('user_id');
            (new User())->delete($userId);

            return redirect('/admin-panel/users');
        }

        return redirect('/admin-panel/users');
    }
}