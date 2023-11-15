<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use App\Models\Program;
use App\Http\Resources\ProgramResource;

use Exception;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * @OA\Get(
         *     path="/program",
         *     tags={"program"},
         *     summary="Returns a Sample API response",
         *     description="A sample greeting to test out the API",
         *     operationId="greet",
         *     @OA\Parameter(
         *          name="firstname",
         *          description="nama depan",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *     ),
         *     @OA\Parameter(
         *          name="lastname",
         *          description="nama belakang",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *     ),
         *     @OA\Response(
         *         response="default",
         *         description="successful operation"
         *     )
         * )
         */
    //
        //
        $data = Program::latest()->get();
        //return response()->json([ProgramResource::collection($data)->paginate(25), 'Programs fetched.']);
        return ProgramResource::collection(Program::paginate(100));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * @OA\Post(
         *     path="/program",
         *     tags={"program"},
         *     summary="Returns a Sample API response",
         *     description="A sample greeting to test out the API",
         *     operationId="greet",
         *     @OA\Parameter(
         *          name="firstname",
         *          description="nama depan",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *     ),
         *     @OA\Parameter(
         *          name="lastname",
         *          description="nama belakang",
         *          required=true,
         *          in="query",
         *          @OA\Schema(
         *              type="string"
         *          )
         *     ),
         *     @OA\Response(
         *         response="default",
         *         description="successful operation"
         *     )
         * )
         */
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $program = Program::create([
                'name' => $request->name,
                'desc' => $request->desc
            ]);

        return response()->json(['Program created successfully.', new ProgramResource($program)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $program = Program::find($id);
        if (is_null($program)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new ProgramResource($program)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function update(Request $request, Program $program)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'desc' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $program->name = $request->name;
        $program->desc = $request->desc;
        $program->save();
        return response()->json(['Program updated successfully.', new ProgramResource($program)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Program $program)
    {
        //
        
        try {
            $program->delete();
            return response()->json('Program deleted successfully');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
