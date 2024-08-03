<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class Permission extends Model
{
    protected string $table = 'permissions';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function detachAllRoles()
    {
        $roleIds = $this->getRoleIds();

        if (empty($roleIds)) {
            return;
        }

        $query = "DELETE FROM permission_role WHERE permission_id = ? AND role_id IN (" . implode(',', array_fill(0, count($roleIds), '?')) . ")";
        $statement = $this->pdo->prepare($query);
        $statement->execute(array_merge([$this->id], $roleIds));
    }


    public function getRoleIds()
    {
        $roleIds = [];
        $roles = $this->roles();

        foreach ($roles as $role) {
            $roleIds[] = $role->id;
        }

        return $roleIds;
    }

    public function detachAllUsers()
    {
        $this->query("DELETE FROM permission_user WHERE permission_id = :permission_id", ['permission_id' => $this->id]);
    }
}