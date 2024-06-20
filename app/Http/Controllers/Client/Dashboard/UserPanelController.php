<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Models\User;
use Mj\PocketCore\Controller;
use Mj\PocketCore\Exceptions\UnauthorizedException;

class UserPanelController extends Controller
{
    public function show(int $userId)
    {
        if ($this->hasAceess($userId)) {
            $user = (new User())->find($userId);

            return view('client.panel.index', compact('user'));
        }

        throw new UnauthorizedException();
    }

    public function edit(int $userId)
    {
        if ($this->hasAceess($userId)) {
            $user = (new User())->find($userId);

            return view('client.panel.edit', compact('user'));
        }

        throw new UnauthorizedException();
    }

    public function update()
    {
        if (request()->has('user_id')) {
            $userId = request()->input('user_id');
            $user = (new User())->find($userId);

            if ($this->hasAceess($userId)) {
                $validation = $this->validate(
                    request()->all(),
                    [
                        'name' => 'required|min:3|max:255',
                        'email' => 'required|email|max:255|unique:users,email,' . $user->email,
                        'password' => 'min:6|max:255',
                        'confirm_password' => 'same:password',
                    ]
                );

                if ($validation->fails()) {
                    // handling errors
                    return redirect('/user-panel/edit/' . $userId);
                }

                $validatedData = $validation->getValidatedData();
                unset($validatedData['confirm_password']);

                if (empty($validatedData['password'])) {
                    unset($validatedData['password']);
                } else {
                    $validatedData['password'] = password_hash($validatedData['password'], PASSWORD_DEFAULT);
                }
                (new User())->update($userId, [...$validatedData]);

                return redirect('/user-panel/' . $userId);
            }

            throw new UnauthorizedException();
        }

        return redirect('/');
    }

    public function delete()
    {
        if (request()->has('user_id')) {
            $userId = request()->input('user_id');

            if ($this->hasAceess($userId)) {
                (new User())->delete($userId);
                auth()->logout();

                return redirect('/');
            }

            throw new UnauthorizedException();
        }

        return redirect('/');
    }

    /**
     * @param int $userId
     * @return bool
     */
    private function hasAceess(int $userId): bool
    {
        return auth()->user()->id === $userId || auth()->user()->hasPermission('user');
    }
}