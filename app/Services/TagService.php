<?php
namespace App\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagService
{
    public function getAllTags(): Collection
    {
        return Tag::query()
            ->select('id', 'name')
            ->get();
    }
}