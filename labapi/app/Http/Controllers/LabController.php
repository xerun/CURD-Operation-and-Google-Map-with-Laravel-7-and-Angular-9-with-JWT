<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Lab;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Lab as LabResource;
use App\Http\Resources\LabCollection;

class LabController extends Controller
{
    public function index()
    {
        return new LabCollection(
			Lab::leftJoin('locations', 'labs.location_id', '=', 'locations.id')
       		->select('labs.*','locations.name as location_name')
       		->get()
    	);
    }

    public function show($id)
    {
        return new LabResource(Lab::findOrFail($id));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[ 
            'name' => 'required | max:191',
            'location_id' => 'required | numeric | gt:0'
        ]);
 
        if($validation->fails()){
            return response()->json([
                'error' => true,
                'messages'  => $validation->errors(),
            ], 403);
        }
        else
        {
	        $lab = Lab::create($request->all());

	        return (new LabResource($lab))
	                ->response()
	                ->setStatusCode(201);
        }	
    }

    public function update($id, Request $request)
    {
    	$validation = Validator::make($request->all(),[ 
            'name' => 'required',
            'location_id' => 'required | numeric | gt:0'
        ]);
 
        if($validation->fails()){
            return response()->json([
                'error' => true,
                'messages'  => $validation->errors(),
            ], 403);
        }
        else
        {
	    	$lab = Lab::findOrFail($id);
	    	$lab->update($request->all());

	        return (new LabResource($lab))
	                ->response()
	                ->setStatusCode(200);
	        }
    }

    public function delete($id)
    {
        $lab = Lab::find($id);

        if(is_null($lab)){
            return response()->json([
                'error' => true,
                'message'  => "Record with id # $id not found",
            ], 404);
        }

        $lab->delete();

        return response()->json(null, 204);
    }
}
