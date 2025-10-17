<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index() {
        $authors = Author::all();

        if ($authors->isEmpty()) {
            return response()->json([
                "success" => false,
                "message" => "Resource data not found",
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Get All Resource",
            "data" => $authors,
        ], 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        $author = Author::create([
            'name' => $request->name,
            'country' => $request->country,
        ]);

        return response()->json([
            'succses' => true,
            'massage' => 'Resource added succesfully!',
            'data'=> $author
        ], 201);
    }
}
