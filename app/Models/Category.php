<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Content;
use phpDocumentor\Reflection\Types\Integer;
class Category extends Model
{
    public function categoryCount()
    {
        return $this->hasMany(Content::class, 'category_id', 'id');
    }
}
