<?php

namespace App\Repositories;

use App\Models\Property\Tag;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class TagRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the Tag model
     */
    public function model(): string
    {
        return Tag::class;
    }

    public function store($data)
    {
        return Tag::create($data);
    }

    public function show(Tag $tag): Tag
    {
        return $tag;
    }

    public function update($data, Tag $tag): Tag
    {
        $tag->update($data);
        return $tag;
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
    }

}
