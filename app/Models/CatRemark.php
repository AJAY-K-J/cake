<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Auth;
class CatRemark extends Model
{
    protected $table='catremarks';
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

}
