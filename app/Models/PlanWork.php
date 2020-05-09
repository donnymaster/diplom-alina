<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanWork extends Model
{
    use SoftDeletes;
    protected $table = "plan_works";

    protected $fillable = ['employee_id', '	departament_id', 'work_id', 'academic_year', 'description',
                        'norm_semester_1_plan', 'norm_semester_2_plan', 'count_plan', '	percentage_plan',
                        'norm_semester_1_fact', 'norm_semester_2_fact', 'count_fact', 'percentage_fact',
                        'materials', 'status', 'title', 'category_id', 'user_count'];

    public function work(){
        return $this->belongsTo('App\Models\Work');
    }
    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function departament(){
        return $this->belongsTo('App\Models\Departments');
    }

    public function category_science(){
        return $this->belongsTo(CategoryWork::class, 'category_id');
    }

}
