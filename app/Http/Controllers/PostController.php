<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posts = Post::with(['car' => function ($query1) {
                $query1->select('*');
            }])
            ->with(['user' => function ($query2) {
                $query2->select('*');
            }])
            ->paginate(10);

            if ($posts->count() > 0) {
                return $this->apiResponse(true, 200, 'Posts fetched successfuly.', $posts);
            } else {
                return $this->apiResponse(false, 404, 'No posts found.');
            }

        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'car_id' => 'required',
                'count_in_package' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $post = Post::create([
                'date_of_publish' => now(),
                'car_id' => $request->car_id,
                'count_in_package' => $request->count_in_package,
                // 'user_id' => auth()->id(),
                'user_id' => 1,
            ]);

            if ($post) {
                return $this->apiResponse(true, 201, 'Post created successfully.', $post);
            } else {
                return $this->apiResponse(false, 400, 'Create post faild.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = Post::find($id);

            if ($post) {
                return $this->apiResponse(true, 200, 'Post fetched successfully.', $post);
            } else {
                return $this->apiResponse(false, 404, 'Post not found.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'car_id' => 'required',
                'count_in_package' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->apiResponse(false, 422, 'Please fill in all required fields.');
            }

            $post = Post::find($id);

            if ($post) {
                $post->update([
                    'car_id' => $request->car_id,
                    'count_in_package' => $request->count_in_package,
                ]);

                $post->save();

                return $this->apiResponse(true, 200, 'Post updated successfuly.', $post);
            } else {
                return $this->apiResponse(false, 400, 'Update post faild.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);

            if (!$post) {
                return $this->apiResponse(false, 404, 'Post not found.');
            } else {
                Post::where('id', $id)->delete();

                return $this->apiResponse(true, 200, 'Post deleted successfuly.');
            }
        } catch (\Throwable $th) {
            return $this->apiResponse(false, 500, 'Something went wrong.', $th->getMessage());
        }
    }
}
