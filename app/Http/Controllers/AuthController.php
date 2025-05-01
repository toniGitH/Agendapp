<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\LoginRequest;
use App\Http\Requests\UserRequests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function welcome()
    {
        if (Auth::check()) {
            return redirect()->route('contacts.index'); // If the user is authenticated, redirect to the contacts route
        }

        return view('auth.welcome');
    }
    
    public function access()
    {
        // If the user is authenticated, redirect to the contacts route
        /* if (Auth::check()) {
            return redirect()->route('contacts.index');
        } */

        return view('auth.access');
    }

    public function register(RegisterRequest $request)
    {
        // Store only the validated data within $data
        $data = $request->validated();
    
        // Process the image if it has been uploaded
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('profile-images', 'public');
        }
    
        // The user is created using the service
        $this->userService->createUser(
            $data['name'],
            $data['registerUsername'],
            $data['registerPassword'],
            $data['image'] ?? null,
            $data['is_admin'] ?? false
        );

        return to_route('access')->with('success', "User " . strtolower($request->registerUsername) . " created successfully!!<br>Now you can log in to access the Agendapp");
    }

    public function login(LoginRequest $request)
    {
        // Get the validated data from the form request
        $credentials = $request->validated();

        // Check if the user wants to be remembered
        $remember = $request->has('remember');

        // Try to authenticate the user with the provided credentials
        // The second parameter is for the "remember me" functionality. False or any value for not remember the user, and true for remember the user
        if (Auth::attempt([
            'username' => $credentials['loginUsername'], 
            'password' => $credentials['loginPassword']
        ], $remember)) {
            // Protection against session fixation attacks
            $request->session()->regenerate();

            // If the authentication is successful, redirect to the contacts or user.index route
            if (Auth::user()->is_admin) {
                return to_route('users.index');
            } else {
                return to_route('contacts.index');
            }
        }

        // If the authentication is not successful, check if the username exists
        $user = User::where('username', $credentials['loginUsername'])->first();

        // If the username exists but the password is incorrect
        if ($user && !Hash::check($credentials['loginPassword'], $user->password)) {
            return back()->withErrors([ // If you want to return to the previous browser URL
                // Also valid this sintax, if you want to specify the route, home or another:
                // return redirect()->route('home')->withErrors([
                'password' => 'The provided password is incorrect.',
            ], 'login'); // Specify the 'login' bag
        }

        // If the username does not exist
        return back()->withErrors([ // If you want to return to the previous browser URL
        // Also valid this sintax, if you want to specify the route, home or another:
        // return redirect()->route('home')->withErrors([
            'username' => 'The provided username is not registered.',
        ], 'login'); // Specify the 'login' bag
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
        return to_route('welcome');
    }

}
