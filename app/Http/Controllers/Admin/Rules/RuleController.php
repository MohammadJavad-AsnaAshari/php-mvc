<?php

namespace App\Http\Controllers\Admin\Rules;

use App\Models\Role;
use Mj\PocketCore\Controller;

class RuleController extends Controller
{
    public function index()
    {
        $roles = (new Role())->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function show(int $userId)
    {

    }

    public function create()
    {
        return view('admin.roles.create');
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

        return redirect('/admin-panel/roles');
    }

    public function edit(int $roleId)
    {
        $role = (new Role())->find($roleId);

        return view('admin.roles.edit', compact('role'));
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
                ]
            );

            if ($validation->fails()) {
                // handling errors
                return redirect('/admin-panel/roles/' . $roleId);
            }

            $validatedData = $validation->getValidatedData();
            $validatedRoleId = $validatedData['role_id'];
            unset($validatedData['role_id']);

            (new Role())->update($validatedRoleId, [...$validatedData]);

            return redirect('/admin-panel/roles');
        }

        return redirect('/admin-panel/roles');
    }

    public function delete()
    {
        if (request()->has('role_id')) {
            $roleId = request()->input('role_id');
            (new Role())->delete($roleId);

            return redirect('/admin-panel/roles');
        }

        return redirect('/admin-panel/roles');
    }
}