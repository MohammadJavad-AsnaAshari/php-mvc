<?php

namespace App\Models;

use Mj\PocketCore\Database\Model;

class User extends Model
{
    protected string $table = 'users';

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function attachRole(int $roleId)
    {
        $query = "INSERT INTO role_user (user_id, role_id) VALUES (?, ?)";
        $this->pdo->prepare($query)->execute([$this->id, $roleId]);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function attachPermission(int $permissionId)
    {
        $query = "INSERT INTO permission_user (user_id, permission_id) VALUES (?, ?)";
        $this->pdo->prepare($query)->execute([$this->id, $permissionId]);
    }

    public function likes()
    {
        return $this->belongsToMany(Product::class, 'product_like', 'user_id', 'product_id');
    }

    public function likesPost(int $product)
    {
        $pivotModel = new static();
        $pivotModel->from('product_like');
        $pivotModel->where('user_id', $this->id)
            ->where('product_id', $product)
            ->limit(1);

        return $pivotModel->exists();
    }

    public function hasPermission($permission)
    {
        $permissions = $this->permissions();
        foreach ($permissions as $r) {
            if ($r->name === $permission) {
                return true;
            }
        }

        return false;
    }

    public function detachAllPermissions()
    {
        $this->query("DELETE FROM permission_user WHERE user_id = :user_id", ['user_id' => $this->id]);
    }

    public function detachAllRoles()
    {
        $this->query("DELETE FROM role_user WHERE user_id = :user_id", ['user_id' => $this->id]);
    }
}