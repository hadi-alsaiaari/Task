<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Traits\UploadImageFile;
use Illuminate\Support\Facades\Http;

class PostController extends BaseController
{
    use UploadImageFile;

    public $post_repository;

    public function __construct(PostRepository $post_repository)
    {
        $this->post_repository = $post_repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(PostResource::collection($this->post_repository->getPosts()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {
        $data = $request->validated();
        $data['image'] = $this->newUploadFile($request, 'image');

        $post = $this->post_repository->createPost($data);

        return $this->sendResponse(PostResource::make($post->with('tags')), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return PostResource::make($this->post_repository->getPost($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();
        $data['image'] = $this->updateUploadFile($request, 'image', $post->image);
        
        $post = $this->post_repository->updatePost($data, $post->id);

        return $this->sendResponse(PostResource::make($post));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->post_repository->deletePost($id);

        return $this->sendResponse("Deleted!");
    }

    public function trash()
    {
        $posts = $this->post_repository->getPostsTrash();

        return $this->sendResponse(PostResource::collection($posts));
    }

    public function restore($id)
    {
        $this->post_repository->restorePost($id);

        return $this->sendResponse("Restored!");
    }
}
