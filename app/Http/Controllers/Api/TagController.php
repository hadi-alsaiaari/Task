<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Tag\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;

class TagController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse(TagResource::collection(Tag::get()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $tag = Tag::create([
            'name' => $request->validated()['name'],
        ]);

        return $this->sendResponse($tag, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        return $this->sendResponse(TagResource::make($tag));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update([
            'name' => $request->validated()['name'],
        ]);

        return $this->sendResponse($tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return $this->sendResponse("Deleted $tag->name!");
    }
}
