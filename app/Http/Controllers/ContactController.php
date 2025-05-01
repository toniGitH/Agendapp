<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequests\SearchContactRequest;
use App\Http\Requests\ContactRequests\StoreContactRequest;
use App\Http\Requests\ContactRequests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    use AuthorizesRequests;

    public function index(SearchContactRequest $request)
    {
        // Check if the user has permission to view contacts
        $this->authorize('viewAny', Contact::class);

        // Store only the validated data within $data
        $data = $request->validated();

        // Set default values for parameters if they are not present
        $userId = $data['user_id'] ?? Auth::id();
        $sort = $data['sort'] ?? 'last_name_1';  // Default value for the sorting column
        $direction = $data['direction'] ?? 'asc'; // Default value for the direction
        $search = $data['search'] ?? null;

        // Initializes a new Eloquent query builder instance for the Contact model.
        // This allows building and modifying the query (e.g., adding filters, sorting, pagination) before executing it.
        $contacts = Contact::query();

        // If the 'user_id' is not 'all', filter by 'user_id'
        if ($userId !== 'all') {
            $contacts->where('user_id', $userId);
        }

        // If a search term is provided, filter by relevant fields
        if ($search) {
            $contacts->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name_1', 'like', '%' . $search . '%')
                    ->orWhere('last_name_2', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('mobile', 'like', '%' . $search . '%');
            });
        }

        // Apply sorting according to the parameters
        $contacts = $contacts->orderBy($sort, $direction)
            ->paginate(8)
            ->appends(['user_id' => $userId, 'sort' => $sort, 'direction' => $direction, 'search' => $search]);

        return view('contacts.index', compact('contacts', 'userId', 'sort', 'direction', 'search'));
    }

    public function create()
    {
        $users = User::all();
        return view('contacts.create', compact('users'));
    }

    public function store(StoreContactRequest $request)
    {
        // Check in the ContactPolicy if the user can create a contact
        $this->authorize('create', Contact::class);

        // Store only the validated data within $data
        $data = $request->validated();

        // If an image is uploaded, we store it.
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('contacts-images', 'public');
        }

        $contact = Contact::create($data);

        return redirect()->route('contacts.show', $contact)->with('success', 'Contact created successfully!');
    }

    public function show(Contact $contact)
    {
        // Check in the ContactPolicy if the user can view the contact
        $this->authorize('view', $contact);

        $contact->load('user'); // Preload related user
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $users = User::all();
        return view('contacts.edit', compact('contact', 'users'));
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        // Check in the ContactPolicy if the user can update the contact
        $this->authorize('update', $contact);

        $data = $request->validated();

        // If the user checked the checkbox to delete the image
        if ($request->has('delete_image')) {
            // Delete the image from storage if it exists
            if ($contact->image && Storage::disk('public')->exists($contact->image)) {
                Storage::disk('public')->delete($contact->image);
            }
            $data['image'] = null; // Set the image to null in the database
        }
        // If the user uploaded a new image, we process it
        elseif ($request->hasFile('image')) {
            // Delete the old image from storage if it exists
            if ($contact->image && Storage::disk('public')->exists($contact->image)) {
                Storage::disk('public')->delete($contact->image);
            }
            // Save the new image to storage
            $data['image'] = $request->file('image')->store('contacts-images', 'public');
        } else {
            // If no new image has been uploaded and no delete flag was set, keep the current image
            if (isset($data['current_image'])) {
                $data['image'] = $data['current_image'];
            }
        }

        // Remove 'current_image' from the data before updating
        unset($data['current_image']);

        // Update the contact with the validated data
        $contact->update($data);

        // Redirect to the contact's show page with a success message
        return redirect()
            ->route('contacts.show', $contact)
            ->with('success', 'Contact updated successfully!');
    }

    public function destroy(Contact $contact)
    {
        // Check in the ContactPolicy if the user can delete the contact
        $this->authorize('delete', $contact);

        // Check if the contact has an image and delete it
        if ($contact->image) {
            // Use the Storage method to delete the image
            Storage::delete($contact->image);
        }

        // Delete the contact record
        $contact->delete();

        // The contact's image file is automatically deleted via a model event in Contact::booted()

        // Redirect with a success message
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
    }

    public function destroyAll(User $user)
    {
        // The criteria to execute this method is evaluated by the UserPolicy
        // Check in the UserPolicy if the user can delete ALL the user's contacts
        $this->authorize('deleteAllContacts', User::class);

        $user->contacts->each(function ($contact) {
            $contact->delete();
            // The contact's image file is automatically deleted via a model event in Contact::booted()
        });

        return redirect()->route('users.profile', $user)->with('success', 'All user\'s contacts have been deleted');
    }

    public function transferAll(Request $request, User $user)
    {
        // The criteria to execute this method is evaluated by the UserPolicy
        // Check in the UserPolicy if the user can transfer ALL the user's contacts
        $this->authorize('transferAllContacts', User::class);
        
        $request->validate([
            'new_owner' => 'required|exists:users,id'
        ]);

        $newOwnerId = $request->input('new_owner');

        // Transfer all contacts to another user
        Contact::where('user_id', $user->id)->update(['user_id' => $newOwnerId]);

        return redirect()->route('users.profile', $user)->with('success', 'All contacts have been transferred.');
    }
}
