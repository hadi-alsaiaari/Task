<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use App\Traits\UploadImageFile;

class PostRepository implements PostRepositoryInterface
{
    use UploadImageFile;

    public function getPosts()
    {
        return auth()->user()->posts()->orderBy('pinned', 'desc')->with('tags')->paginate();
    }

    public function getPost(int $id)
    {
        return auth()->user()->posts()->findOrFail($id)->load('tags');
    }

    public function createPost($data)
    {
        $data['user_id'] = auth()->id();

        $post = Post::create($data);

        $post->tags()->sync($data['tags']);

        return $post->load('tags');
    }

    public function updatePost($data, $id)
    {
        $post = $this->getPost($id);

        $post->update($data);

        $post->tags()->sync($data['tags']);

        return $post->load('tags');
    }

    public function deletePost($id)
    {
        $this->getPost($id)->delete();
    }

    public function getPostsTrash()
    {
        return auth()->user()->posts()->onlyTrashed()->orderBy('pinned', 'desc')->with('tags')->paginate();
    }

    public function restorePost(int $id)
    {
        auth()->user()->posts()->onlyTrashed()->findOrFail($id)->restore();
    }
}
