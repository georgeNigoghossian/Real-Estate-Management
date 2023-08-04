<?php

namespace App\Http\Controllers\App\Property;

use App\Http\Controllers\App\AppController;
use App\Http\Requests\Property\TagStoreRequest;
use App\Http\Requests\Property\TagUpdateRequest;
use App\Models\Property\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends AppController
{

    public function __construct(TagRepository $tag_repository)
    {
        $this->tag_repository = $tag_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $tags = QueryBuilder::for(Tag::class)
            ->allowedFilters([
                AllowedFilter::scope('term','Search'),
                AllowedFilter::scope('active','Active'),
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
     * @return JsonResponse
     */
    public function store(TagStoreRequest $request): JsonResponse
    {
        $tag = $this->tag_repository->store($request->validated());
        return $this->response(true, $tag, "Tag has been created successfully", 201);

    }

    /**
     * Display the specified resource.
     *
     * @param Tag $tag
     * @return JsonResponse
     */
    public function show(Tag $tag): JsonResponse
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
     * @return JsonResponse
     */
    public function update(TagUpdateRequest $request, Tag $tag): JsonResponse
    {
        $tag = $this->tag_repository->update($request->validated(), $tag);
        return $this->response(true, $tag, 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tag $tag
     * @return JsonResponse
     */
    public function destroy(Tag $tag): JsonResponse
    {
        $this->tag_repository->destroy($tag);
        return $this->response(true, null, 'Tag deleted successfully');
    }
}
