<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeWork extends Model
{
    protected $table = "type-works";
    use SoftDeletes;

    public function work_kind(){
        return $this->hasOne('App\Models\WorkKind', 'type_work_id');
    }

    public function category_name(){
        return $this->belongsTo('App\Models\CategoryName');
    }
}
