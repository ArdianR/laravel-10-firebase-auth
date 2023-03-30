<?php

namespace App\Http\Controllers;

use App\Services\FirebaseAuthenticationService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuthenticationService $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            $this->firebaseAuth->loginUser($email, $password);
            Auth::attempt(['email' => $email, 'password' => $password]);

            return redirect()->intended('/');
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
        }
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $uid = $this->firebaseAuth->registerUser($email, $password);

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->firebase_uid = $uid;
        $user->save();

        Auth::login($user);

        return redirect()->intended('/');
  }
  
  public function logout()
  {
      auth()->logout();

      return redirect('/');
  }
}