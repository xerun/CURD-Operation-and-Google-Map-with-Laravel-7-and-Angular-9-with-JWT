<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Location;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Location as LocationResource;
use App\Http\Resources\LocationCollection;

class LocationController extends Controller
{
    public function index()
    {
        return new LocationCollection(Location::all());
    }

    public function show($id)
    {
        return new LocationResource(Location::findOrFail($id));
    }

    public function store(Request $request)
    {
		$validation = Validator::make($request->all(),[ 
            'name' => 'required | max:191',
            'address' => 'required | max:255',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
 
        if($validation->fails()){
            return response()->json([
                'error' => true,
                'messages'  => $validation->errors(),
            ], 403);
        }
        else
        {
	        $location = Location::create($request->all());

	        return (new LocationResource($location))
	                ->response()
	                ->setStatusCode(201);
        }
    }

    public function update($id, Request $request)
    {
    	$validation = Validator::make($request->all(),[ 
            'name' => 'required | max:191',
            'address' => 'required | max:255',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
 
        if($validation->fails()){
            return response()->json([
                'error' => true,
                'messages'  => $validation->errors(),
            ], 403);
        }
        else
        {
	    	$location = Location::findOrFail($id);
	    	$location->update($request->all());

	        return (new LocationResource($location))
	                ->response()
	                ->setStatusCode(200);
        }
    }

    public function delete($id)
    {
        $location = Location::find($id);

        if(is_null($location)){
            return response()->json([
                'error' => true,
                'message'  => "Record with id # $id not found",
            ], 404);
        }

        $location->delete();

        return response()->json(null, 204);
    }
}
