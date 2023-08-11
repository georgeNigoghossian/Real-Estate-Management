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

    public function get_all($custom_cond = [], $perPage = 10) {
        $query = Tag::query();

        if (count($custom_cond) > 0) {
            $custom_cond = implode(' AND ', $custom_cond);
            $query = $query->whereRaw($custom_cond);
        }

        return $query->paginate($perPage);
    }

    public function get_single_tag($id)
    {

        return Tag::find($id);
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

    public function changeActiveStatus($tag_id,$status){
        $tag = Tag::where('id',$tag_id)->update([
            'active'=>$status,
        ]);
        return $tag;
    }


}
