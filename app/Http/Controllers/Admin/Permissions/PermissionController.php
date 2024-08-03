<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Models\Permission;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Database\Database;
use Mj\PocketCore\Exceptions\NotFoundException;
use Mj\PocketCore\Exceptions\ServerException;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = (new Permission())->get();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store()
    {
        $validation = $this->validate(
            request()->all(),
            [
                'name' => 'required|min:3|max:255',
                'label' => 'required|min:3|max:255',
            ]
        );

        if ($validation->fails()) {
            // handling errors
            return redirect('/admin-panel/permissions/create');
        }

        $validatedData = $validation->getValidatedData();

        (new Permission())->create([...$validatedData]);

        return redirect('/admin-panel/permissions');
    }

    public function edit(int $permissionId)
    {
        $permission = (new Permission())->find($permissionId);

        return view('admin.permissions.edit', compact('permission'));
    }

    public function update()
    {
        if (request()->has('permission_id')) {
            $permissionId = request()->input('permission_id');
            $validation = $this->validate(
                request()->all(),
                [
                    'permission_id' => 'required|numeric|exists:permissions,id',
                    'name' => 'required|min:3|max:255',
                    'label' => 'required|min:3|max:255',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/permissions/edit/' . $permissionId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedRoleId = $validatedData['permission_id'];
            unset($validatedData['permission_id']);

            (new Permission())->update($validatedRoleId, [...$validatedData]);

            return redirect('/admin-panel/permissions');
        }

        return redirect('/admin-panel/permissions');
    }

    public function delete()
    {
        if (request()->has('permission_id')) {
            $permissionId = request()->input('permission_id');

            // Start a new transaction
            $db = new Database();
            $db->beginTransaction();

            try {
                $permission = (new Permission())->find($permissionId);

                if ($permission) {
                    // Detach the permission from the permission
                    $permission->detachAllUsers();
                    $permission->delete($permissionId);

                    // Commit the transaction
                    $db->commit();
                }

                return redirect('/admin-panel/permissions');
            } catch (\Exception $e) {
                // Log the error
                error_log($e->getMessage());

                // Rollback the transaction
                $db->rollback();

                throw new ServerException('Can not delete permissions!');
            }
        }

        throw new NotFoundException('Permission id not fount!');
    }
}