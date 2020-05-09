<?php

namespace App\Services;

use App\Models\PlanWork;

class SortUserWork{



    public static function sort($request, $user_id){

    $works = '';
    $get_req = array();
    $buffer = array();

            switch ($request->input('value')) {
                case '1':
                    if($request->input('type-sort') == 'desc'){
                        $works = PlanWork::orderBy('academic_year', 'desc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 1; $get_req['type'] = 'desc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }else{
                        $works = PlanWork::orderBy('academic_year', 'asc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 1; $get_req['type'] = 'asc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }
                    break;
                case '2':
                    if($request->input('type-sort') == 'desc'){
                        $works = PlanWork::orderBy('created_at', 'desc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 2; $get_req['type'] = 'desc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }else{
                        $works = PlanWork::orderBy('created_at', 'asc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 2; $get_req['type'] = 'asc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }
                    break;
                case '3':
                    if($request->input('type-sort') == 'desc'){
                        $works = PlanWork::orderBy('title', 'desc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 3; $get_req['type'] = 'desc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }else{
                        $works = PlanWork::orderBy('title', 'asc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 3; $get_req['type'] = 'asc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }
                    break;
                case '4':
                    if($request->input('type-sort') == 'desc'){
                        $works = PlanWork::orderBy('count_plan', 'desc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 4; $get_req['type'] = 'desc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }else{
                        $works = PlanWork::orderBy('count_plan', 'asc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 4; $get_req['type'] = 'asc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }
                    break;
                case '5':
                    if($request->input('type-sort') == 'desc'){
                        $works = PlanWork::orderBy('count_fact', 'desc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 5; $get_req['type'] = 'desc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }else{
                        $works = PlanWork::orderBy('count_fact', 'asc')
                        ->where([
                            ['employee_id', '=', $user_id],
                            ['status', '=', 1]
                        ])
                        ->with(['work', 'category_science'])
                        ->paginate(15);
                        $get_req['val'] = 5; $get_req['type'] = 'asc';
                        $buffer['value'] = $works; $buffer['get'] = $get_req;
                    }
                    break;
                default:
                    # code...
                    break;
            }
        return $buffer;
    }
}
