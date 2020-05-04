<?php

namespace App\Models;
use App\Models\CategoryWork;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryName extends Model
{
    protected $table = 'category_name';
    use SoftDeletes;

    protected $fillable = ['name'];

    public function type_work(){
        return $this->hasOne('App\Models\TypeWork');
    }

    public function category_work()
    {
        return $this->hasMany(CategoryWork::class, 'category_id');
    }
}
