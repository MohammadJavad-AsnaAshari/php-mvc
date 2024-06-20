<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Models\Permission;
use App\Models\Role;
use Mj\PocketCore\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = (new Permission())->get();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function show(int $userId)
    {

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
            return redirect('/admin-panel/users/create');
        }

        $validatedData = $validation->getValidatedData();

        (new Role())->create([...$validatedData]);

        return redirect('/admin-panel/permissions');
    }

    public function edit(int $roleId)
    {
        $role = (new Role())->find($roleId);

        return view('admin.permissions.edit', compact('role'));
    }

    public function update()
    {
        if (request()->has('role_id')) {
            $roleId = request()->input('role_id');
            $validation = $this->validate(
                request()->all(),
                [
                    'role_id' => 'required|numeric|exists:permissions,id',
                    'name' => 'required|min:3|max:255',
                    'label' => 'required|min:3|max:255',
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/permissions/' . $roleId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedRoleId = $validatedData['role_id'];
            unset($validatedData['role_id']);

            (new Role())->update($validatedRoleId, [...$validatedData]);

            return redirect('/admin-panel/permissions');
        }

        return redirect('/admin-panel/permissions');
    }

    public function delete()
    {
        if (request()->has('role_id')) {
            $roleId = request()->input('role_id');
            (new Role())->delete($roleId);

            return redirect('/admin-panel/permissions');
        }

        return redirect('/admin-panel/permissions');
    }
}