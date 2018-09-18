<?php

namespace SocialNetwork\Http\Controllers;
use SocialNetwork\Post;
use Illuminate\Http\Request;
use DB;
use Auth;
class PostController extends Controller
{

    public function addPost(Request $request){
        $content = $request->contents;
        $createPost = DB::table('posts')
            ->insert([
                'user_id'=>Auth::user()->id,
                'content'=>$content,
                'status'=>0,
                'created_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
            ]);

        if($createPost) {
            //ai function ta hoche load na kore data deker jonno
            return Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
        }
    }

    public function deletePost($id){
        $deletePost = DB::table('posts')->where('id',$id)->delete();
        if($deletePost){
            //ai function ta hoche load na kore data deker jonno
            return Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
        }
    }
    public function likePost($id){
        $likePost = DB::table('likes')->insert([
            'user_id' => Auth::user()->id,
            'post_id' => $id,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ]);
        if($likePost){
            //ai function ta hoche load na kore data deker jonno OR It need for Every action. otherwise data not show in front page
            return Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
        }
    }
    public function addComment(Request $request){
        $comment = $request->comment;
        $id = $request->id;
        $createComment = DB::table('comments')
            ->insert([
                'user_id'=>Auth::user()->id,
                'post_id'=>$id,
                'comment'=>$comment,
            ]);

        if($createComment) {
            //ai function ta hoche load na kore data deker jonno
            return Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
        }
    }

    public function saveImg(Request $request){
        $img = $request->get('image');

        // remove extra parts.
        $exploded = explode(",",$img);

        if(str_contains($exploded[0], 'gif')){
            $ext = 'gif';
        }else if(str_contains($exploded[0], 'png')){
            $ext = 'png';
        }else{
            $ext = 'jpg';
        }

        //decode.
        $decode = base64_decode($exploded[1]);
        $fileName = str_random() . "." . $ext;

        //path of your local folder
        $path = public_path() . "/img/" .$fileName;

        //upload image to your path.
        if(file_put_contents($path,$decode)){
            $content = $request->contents;
            $createPost = DB::table('posts')
                ->insert([
                    'user_id'=>Auth::user()->id,
                    'content'=>$content,
                    'image'=>$fileName,
                    'status'=>0,
                    'created_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at'=> \Carbon\Carbon::now()->toDateTimeString(),
                ]);

            if($createPost) {
                //ai function ta hoche load na kore data deker jonno
                return Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
            }
        }
    }
    public function updatePost($id, Request $request){
        $updatePost = DB::table('posts')->where('id',$id)->update([
            'content' => $request->updatedContent,
        ]);
        if($updatePost){
            return Post::with('user','likes','comments')->orderBy('created_at','DESC')->get();
        }
    }

    public function search(Request $request){
        $qry =  $request->qry;
        return $users = DB::table('users')->where('name','like', '%'. $qry . '%')->get();
    }
}






