<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function get($id) {
        try{
            $sanitizedId = (int) filter_var($id, FILTER_VALIDATE_INT);

            if(!is_numeric($sanitizedId) || $sanitizedId < 0) {
                return response()->json(['success' => false, 'message' => 'Invalid ID parameter'], 400);
            }

            $user = User::find($sanitizedId);

            if(empty($user)) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            $userAuthId = auth()->user()->id;

            if($user->id !== $userAuthId) {
                return response()->json(['success' => false, 'message' => 'User mismatch'], 401);
            }

            if(empty($user)) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            return response()->json(['success' => true, 'user' => $user], 200);

        }catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error on user query verify your request: ' . var_export($e->getMessage(), true)], 400);
        }
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();

            return response()->json(['success' => true], 201);
        }catch(Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Error: ' . var_export($e->getMessage(), true)], 400);
        }

    }

    public function update(Request $request, $id){
        DB::beginTransaction();

        try{
            $user = User::find($id);

            if(empty($user)) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            $userAuthId = auth()->user()->id;

            if($user->id !== $userAuthId) {
                return response()->json(['success' => false, 'message' => 'User mismatch'], 401);
            }

            if(!empty($request->name)) {
                $user->name = $request->name;
            }

            if(!empty($request->email)) {
                $user->email = $request->email;
            }

            if(!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();

            return response()->json(['success' => true], 200);
        }catch(Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Error: ' . var_export($e->getMessage(), true)], 400);
        }

    }

    public function delete($id) {
        try{
            $user = User::find($id);

            if(empty($user)) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            $userAuthId = auth()->user()->id;

            if($user->id !== $userAuthId) {
                return response()->json(['success' => false, 'message' => 'User mismatch'], 401);
            }

            $user->delete();

            return response()->json(['success' => true], 200);
        }catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . var_export($e->getMessage(), true)], 400);
        }

    }

    public function login(Request $request) {
        try{
            $user = User::where('email', $request->email)->first();

            if(empty($user)) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken('api')->plainTextToken;
            }

            return response()->json(['success' => true, 'token' => $token, 'user' => $user], 200);
        }catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . var_export($e->getMessage(), true)], 400);
        }

    }

    public function logout(Request $request) {
        try{
            $user = User::where('email', $request->email)->first();

            if(empty($user)) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            $userAuthId = auth()->user()->id;

            if($user->id !== $userAuthId) {
                return response()->json(['success' => false, 'message' => 'User mismatch'], 401);
            }

            $result = $user->tokens()->delete();

            return response()->json(['success' => true, 'logout' => $result], 200);
        }catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . var_export($e->getMessage(), true)], 400);
        }

    }
}
