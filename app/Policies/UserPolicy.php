<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{

    public function viewAny(User $user)
    {
        // Only admin users can acces to users list
        return $user->is_admin;
    }

    public function create(User $user): bool
    {
        // Only admin users can create new users
        return $user->is_admin;
    }

    public function edit(User $user, User $model): bool
    {
        // Only admin users can acces to all users edit forms
        // A no admin user can acces to his own edit user form
        return $user->is_admin || $user->id === $model->id;
    }

    public function update(User $user, User $model): bool
    {
        // Only admin users can update users
        // A no admin user can update himself
        return $user->is_admin || $user->id === $model->id;
    }

    public function assignRole(User $user, User $model): bool
    {
        // Only admin users can assign roles, but an admin user can´t modify his own role
        return $user->is_admin && $user->id !== $model->id;
    }

    public function transferAllContacts(User $user){
        // Only admin users can transfer ALL contacts, but a no admin user can transfer ALL his own contacts
        return $user->is_admin || $user->id === Auth::user()->id;
    }

    public function deleteAllContacts(User $user){
        // Only admin users can transfer ALL contacts, but a no admin user can transfer ALL his own contacts
        return $user->is_admin || $user->id === Auth::user()->id;
    }

    public function profile(User $user, User $model): bool
    {
        // Only admin users can acces to all users delete forms
        // A no admin user can acces to his own edit user form
        return $user->is_admin || $user->id === $model->id;
    }

    public function destroy(User $user, User $model): bool
    {
        // Only admin users can destroy users
        // A no admin user can destroy himself
        return $user->is_admin || $user->id === $model->id;
    }
}
