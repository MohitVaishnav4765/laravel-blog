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
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Builder $builder)
    {
        $validator = JsValidatorFacade::formRequest(UserRequest::class, '#form');
        $countries = Country::all();
        $view_type = 'LISTING';
        $view_title = 'Admin Listing';
        $request_type = $request->get('request') ?? '';

        if ($request->ajax() && $request_type == 'ajax_listing') {
            $users = User::all();
            return DataTables::of($users)
                ->addColumn('image', function ($user) {
                    $image_name = 'no_image.jpeg';
                    if ($user->profile_image) {
                        $image_name = $user->profile_image;
                    }

                    return '<img src="' . Storage::url('uploads/' . $image_name) . '" class="img-fuild rounded">';
                })
                ->rawColumns(['image'])
                ->removeColumn('id')
                ->make(true);
        }

        $builder->ajax(route('users.index', ['request' => 'ajax_listing']));

        $dt_table = $builder->columns([
            ['data' => 'image', 'name' => 'image', 'title' => 'Profile Image', 'orderable' => false, 'searchable' => false, 'width' => '10%'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name', 'orderable' => true],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'orderable' => true],
            ['data' => 'phone', 'name' => 'phone', 'title' => 'Phone', 'orderable' => true],
        ])->setTableId('user-table');

        return view('users.users', compact(['validator', 'countries', 'dt_table']));
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
                if (Storage::putFileAs('uploads', $profile_image, $profile_image->getClientOriginalName())) {
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


    public function getStates(Request $request)
    {
        try {
            $states_query = State::query();
            if (filled($request->country_id)) {
                $states_query->where('country_id', $request->country_id);
            }

            if (filled($request->search)) {
                $states_query->where('state_name', 'LIKE', "%$request->search%");
            }
            $states = $states_query->get();
            return response()->json($states);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function getCities(Request $request)
    {
        try {
            $cities_query = City::query();
            if (filled($request->state_id)) {
                $cities_query->where('state_id', $request->state_id);
            }

            if (filled($request->search)) {
                $cities_query->where('city_name', 'LIKE', "%$request->search%");
            }
            $cities = $cities_query->get();
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
