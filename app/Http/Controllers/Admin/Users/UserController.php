<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Request;

class UserController extends Controller
{
    public function index()
    {
        $sql = "SELECT users.*, GROUP_CONCAT(permissions.name) as permissions
                FROM users
                LEFT JOIN permission_user ON users.id = permission_user.user_id
                LEFT JOIN permissions ON permission_user.permission_id = permissions.id
                GROUP BY users.id
                ";
        $users = (new User())->query($sql);

        return view('admin.users.index', compact('users'));
    }

    public function admin()
    {
        $sql = "SELECT users.*, GROUP_CONCAT(permissions.name) as permissions
            FROM users
            LEFT JOIN permission_user ON users.id = permission_user.user_id
            LEFT JOIN permissions ON permission_user.permission_id = permissions.id
            WHERE users.id IN (
                SELECT user_id
                FROM permission_user
                JOIN permissions ON permission_user.permission_id = permissions.id
                WHERE permissions.name = 'admin'
            )
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
        $permissions = (new Permission())->get();
        $roles = (new Role())->get();

        return view('admin.users.create', compact('permissions', 'roles'));
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
                'permissions' => 'array',
                'roles' => 'array'
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/users/create');
        }

        $validatedData = $validation->getValidatedData();
        $validatedPermissions = $validatedData['permissions'];
        $validatedRoles = $validatedData['roles'];

        unset($validatedData['confirm_password']);
        unset($validatedData['permissions']);
        unset($validatedData['roles']);

        // Start a new transaction
        $db = new Database();
        $db->beginTransaction();

        try {
            $user = (new User());
            $user->create([
                ...$validatedData,
                'password' => password_hash($validatedData['password'], PASSWORD_DEFAULT)
            ]);

            $user = $user
                ->where('name', $validatedData['name'])
                ->where('email', $validatedData['email'])
                ->first();

            // Attach permissions to the user
            if (!empty($validatedPermissions)) {
                foreach ($validatedPermissions as $key => $permissionId) {
                    $user->attachPermission($permissionId);
                }
            }

            // Attach roles to the user
            if (!empty($validatedRoles)) {
                foreach ($validatedRoles as $key => $roleId) {
                    $user->attachRole($roleId);
                }
            }

            $db->commit();

            return redirect('/admin-panel/users');
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());

            // Rollback the transaction
            $db->rollback();

            return redirect('/admin-panel/users');
        }
    }

    public function edit(int $userId)
    {
        $user = (new User())->find($userId);
        $allPermissions = (new Permission())->get();
        $allRoles = (new Role())->get();

        $userPermissions = $user->permissions();
        $userRoles = $user->roles();

        return view('admin.users.edit',
            compact('user', 'allPermissions', 'allRoles', 'userPermissions', 'userRoles')
        );
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
                    'permissions' => 'array',
                    'roles' => 'array'
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/users/edit/' . $userId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedUserId = $validatedData['user_id'];
            $validatedPermissions = $validatedData['permissions'];
            $validatedRoles = $validatedData['roles'];

            unset($validatedData['user_id']);
            unset($validatedData['confirm_password']);
            unset($validatedData['permissions']);
            unset($validatedData['roles']);


            if (empty($validatedData['password'])) {
                unset($validatedData['password']);
            } else {
                $validatedData['password'] = password_hash($validatedData['password'], PASSWORD_DEFAULT);
            }

            // Start a new transaction
            $db = new Database();
            $db->beginTransaction();

            try {
                $user = (new User())->find($validatedUserId);
                if ($user) {
                    $user->update($validatedUserId, [...$validatedData]);

                    // Detach all existing permissions and roles
                    $user->detachAllPermissions();
                    $user->detachAllRoles();

                    // Attach new permissions and roles
                    foreach ($validatedPermissions as $permissionId) {
                        $user->attachPermission($permissionId);
                    }

                    foreach ($validatedRoles as $roleId) {
                        $user->attachRole($roleId);
                    }

                    // Commit the transaction
                    $db->commit();
                }

                return redirect('/admin-panel/users');
            } catch (\Exception $e) {
                // Log the error
                error_log($e->getMessage());

                // Rollback the transaction
                $db->rollback();

                return redirect('/admin-panel/users');
            }
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