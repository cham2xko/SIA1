<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use DB;

class UserController extends Controller 
{
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getUsers()
    {
        // $users = User::all();
        // return response()->json($users, 200);
        // return response()->json(['data' => $users], 200);

        $users = DB::connection('mysql') 
        ->select("Select * from tbl_user");
        //return response()->json($users, 200);

        return $this->successResponse($users);
    }

    public function index(){
        $users = User::all();


        return $this->successResponse($users);
    }

    public function add(Request $request){
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
        ];

        $this->validate($request, $rules);
        $user = User::create($request->all());
        return $this->successResponse($user, Response::HTTP_CREATED);

    }

    public function show($id) {
        $users = User::findOrFail($id);
        return $this->successResponse($users);

    }

    public function update(Request $request, $id) {
        $rules = [
            'username' => 'max:20',
            'password' => 'max:20',
            'gender' => 'in:Male,Female',
        ];
        $this->validate($request, $rules);
        $users = User::findOrFail($id);
        $users->fill($request->all());

        if ($users->isclean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $users->save();
        return $this->successResponse($users);
    }

    public function delete($id) {
        $users = User::findOrFail($id);
        $users->delete();
        return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
    }
}
