<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;


class ContactPolicy
{
    public function create(User $user) // This method is related to the store method in the ContactController
    {
        return true; // All users can create contacts
        //return $user->is_admin; // If only admins can create contacts, apply this line instead
    }

    public function viewAny()
    {
        return true; // All users can view all contacts (contact list)
    }

    public function view()
    {
        return true; // All users can view any individual contact
    }

    public function delete(User $user, Contact $contact)
    {
        // If the user is admin (users whose is_admin field is true in users table) can delete any contact
        if ($user->is_admin) {
            return true;
        }

        // Only the user who created the contact can delete it
        return $user->id === $contact->user_id;
    }

    public function update(User $user, Contact $contact)
    {
        // If the user is admin (users whose is_admin field is true in users table) can uodate any contact
        if ($user->is_admin) {
            return true;
        }

        // Only the user who created the contact can update it
        return $user->id === $contact->user_id;
    }

}
