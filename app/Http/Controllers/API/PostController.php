<?php

namespace App\Http\Controllers\API;

use App\CommentReply;
use App\Http\Controllers\Controller;
use App\Likes;
use App\PagePost;
use App\PostComment;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $posts=PagePost::with(['user','comments','comments.user','comments.reply','likes'])->latest()->paginate(7);
        return response()->json($posts);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
           'Content'=>'required',
        ]);

        $post=PagePost::create([
            'content'=>$request->Content,
            'user_id'=>Auth('api')->user()->id,
        ]);
        return response()->json($post);

    }
    public function storeComment(Request $request){
        $this->validate($request,[
            'comment'=>'required'
        ]);
//$postComments=$request->comment;
//        foreach ( $postComments as $comment){
//
//                    $comments=new PostComment();
//                    $comments->comment= $comment;
//                    $comments->user_id=$request->user_id;
//                    $comments->post_id=$request->post_id;
//                    $comments->save();
//                }
       $comments=PostComment::create([
                            'comment'=>$request->comment,
                            'user_id'=>Auth('api')->user()->id,
                            'post_id'=>$request->post_id,

       ]);
        return response()->json($comments);

    }
    public function storeReply(Request $request){

        $this->validate($request,[
            'reply'=>'required'
        ]);
        $replies=CommentReply::create([
                            'reply'=>$request->reply,
                                       'user_id'=>Auth('api')->user()->id,
                                        'comment_id'=>$request->comment_id,
        ]);
        return response()->json($replies);

    }

    public function allReplies(Request $request)
    {
        $reply=CommentReply::with('user')->where('comment_id','=',$request->comment_id)->get();
        return response()->json($reply);
    }
    public function like(Request $request){
        $like=Likes::where([ 'user_id'=>Auth('api')->user()->id,
            'post_id'=>$request->post_id])->first();
        if($like){
            $like->delete();
        }
        else
        {        $like=Likes::create(['user_id'=>Auth('api')->user()->id,'post_id'=>$request->post_id]);

        }
        return response()->json($like);
    }
    public function update(Request $request)
    {

    }

    public function destroy($id)
    {
        //
    }
}
