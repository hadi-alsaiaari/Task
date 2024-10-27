<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        dd($users);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user = User::create([
            'name' => "Hadi",
            'phone_number' => "00967771445349",
            'password' => Hash::make("password"),
            "verification_code" => 543642,
        ]);
        dd($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => "Hadi",
            'phone_number' => "00967771445349",
            'password' => Hash::make("password"),
        ]);
        
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
