<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class Role extends Model
{
    protected string $table = 'roles';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function attachPermission(int $permissionId)
    {
        try {
            $this->query(
                "INSERT INTO permission_role (role_id, permission_id) VALUES (:role_id, :permission_id)",
                [
                    'role_id' => $this->id,
                    'permission_id' => $permissionId
                ]
            );
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());

            // Throw an exception to propagate the error
            throw $e;
        }
    }

    public function detachPermission()
    {
        try {
            $this->query(
                "DELETE FROM permission_role WHERE role_id = :role_id",
                ['role_id' => $this->id]
            );
        } catch (\Exception $e) {
            // Log the error
            error_log($e->getMessage());

            // Throw an exception to propagate the error
            throw $e;
        }
    }

    public function detachAllPermissions()
    {
        $permissionIds = $this->getPermissionIds();

        if (empty($permissionIds)) {
            return;
        }

        $query = "DELETE FROM permission_role WHERE role_id = ? AND permission_id IN (" . implode(',', array_fill(0, count($permissionIds), '?')) . ")";
        $statement = $this->pdo->prepare($query);
        $statement->execute(array_merge([$this->id], $permissionIds));
    }


    public function getPermissionIds()
    {
        $permissionIds = [];
        $permissions = $this->permissions();

        foreach ($permissions as $permission) {
            $permissionIds[] = $permission->id;
        }

        return $permissionIds;
    }
}