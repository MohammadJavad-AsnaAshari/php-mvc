<?php

namespace App\Http\Controllers\Admin\Users;

use App\Models\Permission;
use App\Models\User;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Exceptions\NotFoundException;
use Mj\PocketCore\Exceptions\ServerException;
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

        return view('admin.users.create', compact('permissions'));
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
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/users/create');
        }

        $validatedData = $validation->getValidatedData();
        $validatedPermissions = $validatedData['permissions'];

        unset($validatedData['confirm_password']);
        unset($validatedData['permissions']);

        // Start a new transaction
        $db = new Database();
        $db->beginTransaction();

        try {
            $user = (new User());
            $user->create([
                ...$validatedData,
                'password' => password_hash($validatedData['password'], PASSWORD_DEFAULT)
            ]);

            // Attach permissions to the user
            if (!empty($validatedPermissions)) {
                foreach ($validatedPermissions as $key => $permissionId) {
                    $user->attachPermission($permissionId);
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

        $userPermissions = $user->permissions();

        return view('admin.users.edit',
            compact('user', 'allPermissions', 'userPermissions')
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
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/users/edit/' . $userId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedUserId = $validatedData['user_id'];
            $validatedPermissions = $validatedData['permissions'];

            unset($validatedData['user_id']);
            unset($validatedData['confirm_password']);
            unset($validatedData['permissions']);


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

                    // Detach all existing permissions
                    $user->detachAllPermissions();

                    // Attach new permissions
                    foreach ($validatedPermissions as $permissionId) {
                        $user->attachPermission($permissionId);
                    }

                    // Commit the transaction
                    $db->commit();

                    return redirect('/admin-panel/users');
                }

                throw new NotFoundException('This user does not exist!');
            } catch (\Exception $e) {
                // Log the error
                error_log($e->getMessage());

                // Rollback the transaction
                $db->rollback();

                throw new ServerException('Update user failed!');
            }
        }

        return redirect('/admin-panel/users');
    }

    public function delete()
    {
        if (request()->has('user_id')) {
            $userId = request()->input('user_id');
            $user = (new User())->find($userId);
            // Detach all existing permissions
            $user->detachAllPermissions();
            $user->delete($userId);

            return redirect('/admin-panel/users');
        }

        return redirect('/admin-panel/users');
    }

    public function createAdmin()
    {
        $user = (new User())->find('admin@gmail.com', 'email');

        if (!$user) {
            $admin = (new User());
            $admin->create([
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$9/MqqIbeJomr3mqhIrQFuO89k/ghsUqa0FRsfwg8NpldE0tQqkv8O' // password
            ]);

            $permission = (new Permission());
            $permission->create([
                'name' => 'admin',
                'label' => 'admin'
            ]);

            $admin->attachPermission($permission->id);

            return redirect('/auth/login');
        }

        return redirect('/');
    }
}