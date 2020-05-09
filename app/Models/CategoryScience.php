<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryWork extends Model
{
    protected $table = 'category_work';
    use SoftDeletes;

    protected $fillable = ['category_name', 'category_id'];

    public function category_name()
    {
        return $this->belongsTo(CategoryName::class);
    }

    public function plan_work(){
        return $this->hasOne(PlanWork::class);
    }
}
