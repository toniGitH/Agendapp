<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\StoreUserRequest;
use App\Http\Requests\UserRequests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use AuthorizesRequests;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function index(Request $request)
    {   
        $this->authorize('viewAny', User::class); // Check if the user has permission to view users

        $search = $request->input('search');
        $adminFilter = $request->input('admin_filter');
        $userFilter = $request->input('user_filter');
    
        $query = User::query();
    
        if ($search) {
            $query->where('username', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%');
        }
    
        if ($adminFilter && !$userFilter) {
            $query->where('is_admin', true);
        } elseif (!$adminFilter && $userFilter) {
            $query->where('is_admin', false);
        }
    
        $users = $query->orderBy('username', 'asc')
            ->paginate(4)
            ->appends([
                    'search' => $search,
                    'admin_filter' => $adminFilter,
                    'user_filter' => $userFilter
                ]);
    
        return view('users.index', compact('users', 'search', 'adminFilter', 'userFilter'));
    }

    public function create()
    {
        $this->authorize('create', User::class); // Check if the user has permission to create users
        
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class); // Check if the user has permission to create users

        // Store only the validated data within $data
        $data = $request->validated();
    
        // Process the image if it has been uploaded
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('profile-images', 'public');
        }
    
        // The user is created using the service
        $this->userService->createUser(
            $data['name'],
            $data['username'],
            $data['password'],
            $data['image'] ?? null,
            $data['is_admin'] ?? false
        );
    
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }
    
    public function show(User $user)
    {
        // Not necessary method
    }

    public function edit(User $user)
    {
        $this->authorize('edit', $user); // Check if the user has permission to acces to users edit form
        
        $users = User::all();
        
        return view('users.edit', compact('user', 'users'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user); // Check if the user has permission to update users
        
        // Store only the validated data within $data
        $data = $request->validated();
    
         // If the user has checked the box to delete the image
        if ($request->has('delete_image')) {
            if ($user->profile_img && Storage::disk('public')->exists($user->profile_img)) {
                Storage::disk('public')->delete($user->profile_img);
            }
            $data['profile_img'] = null;
        }
        // If the user has uploaded a new image
        elseif ($request->hasFile('image')) {
            // If an old image exists, delete it
            if ($user->profile_img && Storage::disk('public')->exists($user->profile_img)) {
                Storage::disk('public')->delete($user->profile_img);
            }
            // Store the new image
            $data['profile_img'] = $request->file('image')->store('profile-images', 'public');
        } else {
            // If no new image is uploaded, keep the current image
            $data['profile_img'] = $user->profile_img;
        }
    
        // If no new password is provided, remove the field to prevent updating it
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            // If a new password is provided, hash and store it
            $data['password'] = Hash::make($data['password']);
        }
    
        // If the 'new_owner' field is provided, transfer the contacts
        if ($request->has('new_owner') && $request->filled('new_owner')) {
            // Call the transferAll method to transfer the contacts to the new owner
            return app(ContactController::class)->transferAll($request, $user);
        }
    
        // Update the user with the new data
        $user->update($data);
    
        // Redirection after update
            if (Auth::user()->is_admin) {
                return redirect()
                ->route('users.index')
                ->with('success', 'User updated successfully!');
            } else {
                return redirect()
                ->route('contacts.index')
                ->with('success', 'User updated successfully!');
            }
    }
    
    public function profile(User $user)
    {

        $this->authorize('profile', $user); // Check if the user has permission to acces to users delete form
        
        $users = User::where('id', '!=', $user->id)->get();
        
        return view('users.profile', compact('user', 'users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user); // Check if the user has permission to destroy users
    
        if ($user->contacts()->exists()) {
            return redirect()->back()->with('error', 'You cannot delete your account while you have contacts.');
        }
    
        $user->delete();
        // The user's profile image file is automatically deleted via a model event in User::booted()
    
        return redirect()->route('welcome')->with('success', 'User deleted successfully.');
    }
    

}
