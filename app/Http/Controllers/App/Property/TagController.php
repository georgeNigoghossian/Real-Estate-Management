<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Property\TagStoreRequest;
use App\Http\Requests\Property\TagUpdateRequest;
use App\Models\Property\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @param TagRepository $tag_repository
     */
    public function __construct(TagRepository $tag_repository)
    {
        $this->tag_repository = $tag_repository;
    }
    public function index(Request $request): array
    {
        $columns = Schema::getColumnListing('tags');
        $tags = QueryBuilder::for(Tag::class)
            ->allowedFilters([
                ...$columns
            ])
            ->allowedSorts([
                ...$columns
            ])
            ->paginate($request->per_page);
        return $this->response(true, $tags, "All Tags");
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
     * @param TagStoreRequest $request
     * @return array
     */
    public function store(TagStoreRequest $request): array
    {
        $tag = $this->tag_repository->store($request->validated());
        return $this->response(true, $tag, "Tag has been created successfully", 201);

    }

    /**
     * Display the specified resource.
     *
     * @param Tag $tag
     * @return array
     */
    public function show(Tag $tag): array
    {
        $tag = $this->tag_repository->show($tag);
        return $this->response(true, $tag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagUpdateRequest $request
     * @param Tag $tag
     * @return array
     */
    public function update(TagUpdateRequest $request, Tag $tag): array
    {
        $tag = $this->tag_repository->update($request->validated(), $tag);
        return $this->response(true, $tag, 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return array
     */
    public function destroy(Tag $tag): array
    {
        $this->tag_repository->destroy($tag);
        return $this->response(true, null, 'Tag deleted successfully');
    }
}
