<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Blogs;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validate = $this->validate($request, ['user_id' => 'required']);

        if ($validate) {
            $check_user = DB::table('users')
                        ->where(['id'=>$request->user_id,
                                 'isDeleted'=>0])
                        ->get();
            $cnt = count($check_user);

            if ($cnt != 0 ) {
                $data = Blogs::where(['user_id'=>$request->id, 'isDeleted'=>0])
                ->get();
                $blog_cnt = count($data);

                if ($blog_cnt != 0) {
                    return response()->json(['success' => $data], 200);
                }
                else{
                    return response()->json(['success' => 'No data found.'], 200);
                }
            
            }
            else{
                return response()->json(['error' => 'User not match.'], 201);
            }
        }
        
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

        $validate = $this->validate($request, ['user_id' => 'required',
            'title' => 'required', 'string',
            'description' => 'required', 'string', 
            'image' => 'required']);

        if ($validate) {
            $check_user = DB::table('users')
                        ->where(['id'=>$request->user_id,
                                 'isDeleted'=>0])
                        ->get();
            $cnt = count($check_user);

            if ($cnt != 0 ) {
                if ($request->hasFile('image') && $request->image->isvalid()) {
                $file = $request->image->getClientOriginalName(); //Get Image Name
                $file_name = time(). '_' .$file;
                $request->image->move(public_path('/assets/images/blogs/'), $file_name);


            } else {
                $file_name = "no-image.png";

            }

                $Blog = new Blogs;
                $Blog->user_id = $request->user_id;
                $Blog->title = $request->title;
                $Blog->description = $request->description;
                $Blog->image = $file_name;
                $Blog->save();

            return response()->json(['success' => $validate], 200);
                
            }
            else{
                return response()->json(['error' => 'User not match.'], 201);
            }
        }
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $validate = $this->validate($request, ['user_id' => 'required',
            'id' => 'required']);

        if ($validate) {
            $check_user = DB::table('users')
                        ->where(['id'=>$request->user_id,
                                 'isDeleted'=>0])
                        ->get();
            $cnt = count($check_user);

            if ($cnt != 0 ) {
                $blog = Blogs::where(['id'=>$request->id, 'isDeleted'=>0])
                    ->get();
                $cnt_blog = count($blog);

                if ($cnt_blog !=0) {
                
                return response()->json(['success' => $blog], 200);
                }
                else{
                    return response()->json(['error' => 'No data found'], 201);
                }
                
            }
            else{
                return response()->json(['error' => 'User not match.'], 201);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validate = $this->validate($request, ['user_id' => 'required',
            'title' => 'required', 'string',
            'description' => 'required', 'string']);

        if ($validate) {
            $check_user = DB::table('users')
                        ->where(['id'=>$request->user_id,
                                 'isDeleted'=>0])
                        ->get();
            $cnt = count($check_user);

            if ($cnt != 0 ) {
                if ($request->hasFile('image') && $request->image->isvalid()) {
                $file = $request->image->getClientOriginalName(); //Get Image Name
                $file_name = time(). '_' .$file;
                $request->image->move(public_path('/assets/images/blogs/'), $file_name);


            } else {
                $blog_img = Blogs::where(['id'=>$request->id, 'isDeleted'=>0])
                        ->get();

                $file_name = $blog_img[0]->image;
                

            }
            $data = array('title' => $request->title, 'description'=>$request->description , 'image' => $file_name);
                    Blogs::where('id', $request->id)
                    ->update($data);

            return response()->json(['success' => $validate], 200);
                
            }
            else{
                return response()->json(['error' => 'User not match.'], 201);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validate = $this->validate($request, ['user_id' => 'required',
            'id' => 'required', 'string']);

        if ($validate) {
            $check_user = DB::table('users')
                        ->where(['id'=>$request->user_id,
                                 'isDeleted'=>0])
                        ->get();
            $cnt = count($check_user);

            $data = array('isDeleted' => '1');
                    Blogs::where('id', $request->id)
                    ->update($data);

            return response()->json(['success' => 'Blog delete successfully'], 200);
                
            }
            else{
                return response()->json(['error' => 'User not match.'], 201);
            }
        }
    
}
