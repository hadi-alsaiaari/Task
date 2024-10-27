<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function getPosts();

    public function getPost(int $id);

    public function createPost($request);

    public function updatePost($request, $id);

    public function deletePost($id);

    public function getPostsTrash();

    public function restorePost(int $id);
}
