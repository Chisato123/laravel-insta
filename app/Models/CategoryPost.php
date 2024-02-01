<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;
    public $timestamps = false; //no timestamp colums ピポット
    protected $table = "category_post"; //sg
    protected $fillable = ['post_id', 'category_id']; //[]=array, the list of columns that can be mass assigned

    //CateforyPost belongs to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //CateforyPost belongs to Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
