<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;

class Content extends Model
{
    use SoftDeletes;

    public function getCategory()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
}
