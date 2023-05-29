<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
//        if($request->image != null)
//        {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'regex:/^[а-яА-Я]+( [а-яА-Я]+){1,2}$/u'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z]).{6,}$/'],
                'image' => ['nullable', 'image:jpg,jpeg,png'],
                'login' => ['required', 'string', 'max:255', 'unique:'.User::class],
//                regex:/^(?=.[a-z])(?=.[A-Z]).{6,}$/
//            Rules\Password::defaults()
            ]);
//            sС6!saxая

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'image' => $request->image,
                'login' => $request->login,
            ]);
//
            if ($request->hasFile('image'))
            {
                $image = $request->file('image');
                $path = $image->hashName();
                if (!Storage::disk('public')->exists($path))
                {
                    $path = $image->store('', 'public');
                }
                $user->image = $path;
            }

            $user->save();
            event(new Registered($user));
            return redirect('/login');
//            Auth::login($user);
//            return redirect('/login');
        }
//    }
}
