<?php

// app/Http/Controllers/UserTypeController.php

namespace App\Http\Controllers;

use App\Models\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function index()
    {
        $userTypes = UserType::all();
        return view('user_types.index', compact('userTypes'));
    }

    public function create()
    {
        return view('user_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:45',
        ]);

        UserType::create($request->all());

        return redirect()->route('user_types.index')->with('success', 'UserType created successfully.');
    }

    public function show(UserType $userType)
    {
        return view('user_types.show', compact('userType'));
    }

    public function edit(UserType $userType)
    {
        return view('user_types.edit', compact('userType'));
    }

    public function update(Request $request, UserType $userType)
    {
        $request->validate([
            'name' => 'required|string|max:45',
        ]);

        $userType->update($request->all());

        return redirect()->route('user_types.index')->with('success', 'UserType updated successfully.');
    }

    public function destroy(UserType $userType)
    {
        $userType->delete();

        return redirect()->route('user_types.index')->with('success', 'UserType deleted successfully.');
    }
}
