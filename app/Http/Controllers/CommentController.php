<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function getAll() {
        try{
            $comments = Comment::with('user')->paginate(20);

            return response()->json(['success' => true, 'comments' => $comments], 200, ['Accept' => 'application/json']);
        }catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . var_export($e->getMessage(), true)], 400, ['Accept' => 'application/json']);
        }
    }

    public function get($id) {
        try{
            $sanitizedId = (int) filter_var($id, FILTER_VALIDATE_INT);

            if(!is_numeric($sanitizedId) || $sanitizedId < 0) {
                return response()->json(['success' => false, 'message' => 'Invalid ID parameter'], 400);
            }

            $comment = Comment::find($sanitizedId);

            if(empty($comment)) {
                return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
            }

            $userAuthId = auth()->user()->id;

            if($comment->user->id !== $userAuthId) {
                return response()->json(['success' => false, 'message' => 'User mismatch'], 401);
            }

            if(empty($comment)) {
                return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
            }

            return response()->json(['success' => true, 'comment' => $comment], 200);

        }catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error on comment query verify your request: ' . var_export($e->getMessage(), true)], 400);
        }
    }

    public function store(Request $request) {
        DB::beginTransaction();

        try{
            $comment = new Comment();
            $comment->content = $request->content;
            $comment->created_by = auth()->user()->id;
            $comment->save();

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
            $comment = Comment::find($id);

            if(empty($comment)) {
                return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
            }

            $userAuthId = auth()->user()->id;

            if($comment->user->id !== $userAuthId) {
                return response()->json(['success' => false, 'message' => 'User mismatch'], 401);
            }

            if(!empty($request->content)) {
                $comment->content = $request->content;
            }

            $comment->save();

            DB::commit();

            return response()->json(['success' => true], 200);
        }catch(Exception $e) {
            DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Error: ' . var_export($e->getMessage(), true)], 400);
        }

    }

    public function delete($id) {
        try{
            $comment = Comment::find($id);

            if(empty($comment)) {
                return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
            }

            $userAuthId = auth()->user()->id;

            if($comment->user->id !== $userAuthId) {
                return response()->json(['success' => false, 'message' => 'User mismatch'], 401);
            }

            $comment->delete();

            return response()->json(['success' => true], 200);
        }catch(Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . var_export($e->getMessage(), true)], 400);
        }

    }
}
