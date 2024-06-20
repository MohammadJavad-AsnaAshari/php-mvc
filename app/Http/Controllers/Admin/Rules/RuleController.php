<?php

namespace App\Http\Controllers\Admin\Rules;

use App\Models\Permission;
use App\Models\Role;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;

class RuleController extends Controller
{
    public function index()
    {
        $sql = "SELECT roles.*, GROUP_CONCAT(permissions.name) as permissions
                FROM roles
                LEFT JOIN permission_role ON roles.id = permission_role.role_id
                LEFT JOIN permissions ON permission_role.permission_id = permissions.id
                GROUP BY roles.id
                ";
        $roles = (new Role())->query($sql);

        return view('admin.roles.index', compact('roles'));
    }

    public function show(int $userId)
    {

    }

    public function create()
    {
        $permissions = (new Permission())->get();

        return view('admin.roles.create', compact('permissions'));
    }

    public function store()
    {
        $db = new Database();

        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255',
                'label' => 'required|min:3|max:255',
                'permissions' => 'required|array'
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/roles/create');
        }

        $validatedData = $validation->getValidatedData();

        // Start a new transaction
        $db->beginTransaction();

        try {
            // Pass the Database object to the Role model's constructor
            $role = new Role();
            $role->create([
                'name' => $validatedData['name'],
                'label' => $validatedData['label'],
            ]);

            $role = $role
                ->where('name', $validatedData['name'])
                ->where('label', $validatedData['label'])
                ->first();

            foreach ($validatedData['permissions'] as $permissionId) {
                $role->attachPermission($permissionId);
            }

            // Commit the transaction
            $db->commit();

            return redirect('/admin-panel/roles');
        } catch (\Exception $e) {
            error_log($e->getMessage());

            // Rollback the transaction
            $db->rollback();

            // Throw an exception to stop further execution
            throw $e;
        }
    }

    public function edit(int $roleId)
    {
        $role = (new Role())->find($roleId);
        $permissions = (new Permission())->get();
        $rolePermissionIds = $role->getPermissionIds();

        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    public function update()
    {
        if (request()->has('role_id')) {
            $roleId = request()->input('role_id');
            $validation = $this->validate(
                request()->all(),
                [
                    'role_id' => 'required|numeric|exists:roles,id',
                    'name' => 'required|min:3|max:255',
                    'label' => 'required|min:3|max:255',
                    'permissions' => 'required|array',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/roles/' . $roleId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedRoleId = $validatedData['role_id'];
            unset($validatedData['role_id']);

            // Start a new transaction
            $db = new Database();
            $db->beginTransaction();

            try {
                $role = (new Role())
                    ->where('name', $validatedData['name'])
                    ->where('label', $validatedData['label'])
                    ->first();

                if ($role) {
                    // Update the role
                    $role->update(
                        $validatedRoleId,
                        [
                            'name' => $validatedData['name'],
                            'label' => $validatedData['label'],
                        ]
                    );

                    // Detach all existing permissions
                    $role->detachAllPermissions();

                    // Attach new permissions
                    foreach ($validatedData['permissions'] as $permissionId) {
                        $role->attachPermission($permissionId);
                    }

                    // Commit the transaction
                    $db->commit();
                }

                return redirect('/admin-panel/roles');
            } catch (\Exception $e) {
                // Log the error
                error_log($e->getMessage());

                // Rollback the transaction
                $db->rollback();

                // You can add an error message or redirect to an error page here
                return redirect('/admin-panel/roles/' . $roleId);
            }
        }

        return redirect('/admin-panel/roles');
    }

    public function delete()
    {
        if (request()->has('role_id')) {
            $roleId = request()->input('role_id');

            // Start a new transaction
            $db = new Database();
            $db->beginTransaction();

            try {
                $role = (new Role())->find($roleId);

                if ($role) {
                    // Detach the permission from the role
                    $role->detachPermission();
                    $role->delete($roleId);

                    // Commit the transaction
                    $db->commit();
                }

                return redirect('/admin-panel/roles');
            } catch (\Exception $e) {
                // Log the error
                error_log($e->getMessage());

                // Rollback the transaction
                $db->rollback();

                // You can add an error message or redirect to an error page here
                return redirect('/admin-panel/roles');
            }
        }

        return redirect('/admin-panel/roles');
    }
}