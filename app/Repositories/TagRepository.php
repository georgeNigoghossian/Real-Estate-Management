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

    public function get_all($custom_cond = []){


        if(count($custom_cond)>0){
            $custom_cond= implode(' AND ', $custom_cond);

            $tags = Tag::whereRaw($custom_cond)->get();
        }else{
            $tags = Tag::all();
        }

        return $tags;
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
