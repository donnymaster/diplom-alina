<?php

namespace App\Services;

use App\Models\PlanWork;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MakeWorkService{

    public static function make($valid, $request, $st = false){

        $work = new PlanWork;

        $work->employee_id = Auth::user()->employee->id;
        $work->departament_id = $valid['departament'];
        $work->academic_year = Carbon::now()->year;
        $work->work_id = $valid['work'];
        $work->description = $valid['desc-work'];
        $work->title = $valid['work-title'];
        $work->user_count = $valid['user-count'];
        
        if($valid['category_work']){
            $work->category_id = $valid['category_work'];
        }
        if($valid['category_work'] == 'відсутні'){
            $work->category_id = null;
        }else{
            $work->category_id = null;
        }
        $work->status = $st;
        if($request->file('attachment')){
            $files = new AddFileService($request->file('attachment'));
            $json = $files->sendFileToFolder('works');  // отправляем файлы в папку app/uploads/{id}/works/hash/files
            $work->materials = json_encode($json);
        }

        return $work;

    }
}
