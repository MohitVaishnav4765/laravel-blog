<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $validator = JsValidatorFacade::formRequest(UserRequest::class, '#form');
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('users.users', compact(['validator', 'countries', 'states', 'cities']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {

            $validated = $request->validated();

            $user = User::updateOrCreate($validated);
            if ($request->hasFile('profile_image')) {
                $profile_image = $request->file('profile_image');
                if (Storage::put('uploads', $profile_image)) {
                    $user->profile_image = $profile_image->getClientOriginalName();
                    $user->save();
                }
            }
            if ($user) {
                return response()->json(['message' => 'User has been added successfully.']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
