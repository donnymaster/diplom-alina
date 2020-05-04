<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AcademicDegree;
use App\Models\AccountCreationRequest;
use App\Models\Departments;
use App\Models\Employee;
use App\Models\Facultes;
use App\Models\Feedback;
use App\Models\PlanWork;
use App\Models\Post;
use App\Models\TypeWork;
use App\Models\Work;
use App\Models\WorkKind;
use App\Services\DeleteUserDepartament;
use App\Services\SortDegree;
use App\Services\SortDepart;
use App\Services\SortFaculty;
use App\Services\SortGroupWork;
use App\Services\SortPost;
use App\Services\SortQuestionOnAdmin;
use App\Services\SortTypeWork;
use App\Services\SortWork;
use App\Services\UserInfoService;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Type;

class AdministratorController extends Controller
{
    public function index(){

        return view('administrator.index');
    }

    public function users(){

        $dep_users = Employee::with('departament')->paginate(10);
        if($dep_users->count()  != 0){
            $posts = Post::all();
            $degrees = AcademicDegree::all();
            $departaments = Departments::all();
            $facultes = Facultes::all();
            $allDep = response()->json($departaments);

            return view('administrator.users', compact('dep_users','posts', 'degrees', 'allDep', 'facultes'));
        }else{
            $UsersEmpty = 'Користувачі відсутні';
            return view('administrator.users', compact('UsersEmpty'));
        }

        return view('administrator.users');
    }

    public function questions(Request $req){

        $questions = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortQuestionOnAdmin::sort($req);
            $questions =$val['value']; $get_req = $val['get'];
        }else{
            $questions = Feedback::where([
                ['type_user', '=', 3],
                ['status', '=', false]
            ])->paginate(15);

        }

        if($questions->count() == 0){
            return view('administrator.questions', ['noQuestion' => 'Питань немає']);
        }else{
            return view('administrator.questions', compact('questions', 'get_req'));
        }


        return view('administrator.questions');
    }

    public function management(Request $req){

        $facultes = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortFaculty::sort($req);
            $facultes =$val['value']; $get_req = $val['get'];
        }else{
            $facultes = Facultes::withCount('departament')
            ->with('departament')
            ->paginate(15);
        }

        return view('administrator.all-faculty', compact('facultes', 'get_req'));
    }

    public function account(){

        $info = UserInfoService::info();

        return view('administrator.account', $info);
    }

    public function faculty(Request $req, $id){

        $departaments = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortDepart::sort($req, $id);
            $departaments =$val['value']; $get_req = $val['get'];
        }else{
            $departaments = Departments::where('faculty_id', '=', $id)->paginate(15);
        }
        $faculty_name = Facultes::where('id', '=', $id)->first()->faculty_name;
        $facultes = Facultes::all();
        $faculty_id = $id;
        $count_faculty =  Facultes::withCount('departament')
                            ->where('id', '=', $id)->get()[0]->departament_count;
        return view('administrator.faculty', compact('departaments', 'faculty_name', 'facultes', 'count_faculty', 'faculty_id'));
    }

    public function departamentEdit(Request $re){
        //dd($re->all());
        try {
            Departments::where('id', '=', $re->input('id'))
                ->update([
                    'departament_name' => $re->input('departament_name'),
                    'head_departament' => $re->input('head_departament'),
                    'faculty_id' => $re->input('faculty_id')
                ]);
        } catch (\Throwable $th) {
            return back()
            ->with(['errorUpdate' => $th->getMessage()]);
        }
        return back()
            ->with(['goodUpdate' => 'Факультет був оновлений']);
    }

    public function departamentNew(Request $re){
        try {
            $dep = new Departments;
            $dep->departament_name = $re->input('departament_name');
            $dep->head_departament = $re->input('head_departament');
            $dep->faculty_id = $re->input('faculty_id');
            $dep->save();
        } catch (\Throwable $th) {
            return back()
            ->with(['errorUpdate' => $th->getMessage()]);
        }
        return back()
            ->with(['goodUpdate' => 'Факультет був доданий']);
    }

    public function facultyNew(Request $re){
        try {
            $dep = new Facultes;
            $dep->faculty_name = $re->input('faculty_name');
            $dep->head_faculty = $re->input('head_faculty');
            $dep->save();
        } catch (\Throwable $th) {
            return back()
            ->with(['errorUpdate' => $th->getMessage()]);
        }
        return back()
            ->with(['goodUpdate' => 'Факультет був доданий']);
    }

    public function facultyEdit(Request $re){
    try {
        Facultes::where('id', '=', $re->input('id'))
            ->update([
                'faculty_name' => $re->input('faculty_name'),
                'head_faculty' => $re->input('head_faculty')
            ]);
    } catch (\Throwable $th) {
        return back()
        ->with(['errorUpdate' => $th->getMessage()]);
    }
    return back()
        ->with(['goodUpdate' => 'Факультет був оновлений']);
    }

    public function deleteDepartament(Request $re){
        if($re->input('code_delete')){
            $code_env = env('DELETE_DEPARTMENT_CODE');
            $code_req = $re->input('code_delete');
            if($code_env == $code_req){
                DeleteUserDepartament::delete_user_all_departament($re->input('departament_id'));
                return back();
            }else{
                return back();
            }
        }
        return back();
    }

    public function deleteFaculty(Request $re){

        if($re->input('code_delete')){
            $code_env = env('DELETE_FACULTY_CODE');
            $code_req = $re->input('code_delete');
            if($code_env == $code_req){
                $faculty = Facultes::where('id', '=', $re->input('departament_id'))
                    ->with('departament')
                    ->first();
                    foreach ($faculty->departament as $departament) {
                        DeleteUserDepartament::delete_user_all_departament($departament->id);
                    }
                $faculty->delete();
                return back();
            }
            return back();
        }
        return back();
    }

    public function degreeShow(Request $req){
        $degrees = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortDegree::sort($req);
            $degrees =$val['value']; $get_req = $val['get'];
        }else{
            $degrees = AcademicDegree::paginate(15);
        }
        //dd($degrees->total());
        return view('administrator.degree', compact('degrees', 'get_req'));
    }

    public function degreeEdit(Request $re){
        //dd($re->all());
        try {
            AcademicDegree::where('id', '=', $re->input('id'))
                ->update([
                    'degree_name' => $re->input('degree_name')
                ]);
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    public function degreeDelete(Request $re){
        $degree = AcademicDegree::where('id', '=', $re->input('degree_id'))
            ->withCount('employee', 'account_creation_request')->first();
        if($degree->employee_count == 0 && $degree->account_creation_request_count == 0){
            $degree->delete();
             return back();
        }else{
            return back()
                ->with(['noDelete' => 'Ви не можете видалити цю академічну ступінь, тому що інші користувачі використовують її! Видаліть їх акаунти або повідомте щоб вони поміняти свою наукову ступенем'])
                ->withInput();
        }
        return back();
    }

    public function degreeNew(Request $re){
        try {
            $academic = new AcademicDegree;
            $academic->degree_name = $re->input('degree_name');
            $academic->save();
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    public function postShow(Request $req){
        $posts = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortPost::sort($req);
            $posts =$val['value']; $get_req = $val['get'];
        }else{
            $posts = Post::paginate(15);
        }
        return view('administrator.post', compact('posts', 'get_req'));
    }

    public function postEdit(Request $re)
    {
         try {
            Post::where('id', '=', $re->input('id'))
                ->update([
                    'post_name' => $re->input('post_name')
                ]);
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    public function postDelete(Request $re){
        $post = Post::where('id', '=', $re->input('post_id'))
            ->withCount('employee', 'account_creation_request')->first();
        if($post->employee_count == 0 && $post->account_creation_request_count == 0){
            $post->delete();
             return back();
        }else{
            return back()
                ->with(['noDelete' => 'Ви не можете видалити цю посаду, тому що інші користувачі використовують її! Видаліть їх акаунти або повідомте щоб вони поміняти свою посаду'])
                ->withInput();
        }
        return back();
    }

    public function postNew(Request $re){
        try {
            $post = new Post;
            $post->post_name = $re->input('post_name');
            $post->save();
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }


    // type_work
    public function typeWorkShow(Request $req){
        $typeWorks = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortTypeWork::sort($req);
            $typeWorks =$val['value']; $get_req = $val['get'];
        }else{
            $typeWorks = TypeWork::with('work_kind')->paginate(15);
        }
        return view('administrator.type-work', compact('typeWorks', 'get_req'));
    }
    public function typeWorkEdit(Request $re){
        try {
            TypeWork::where('id', '=', $re->input('id'))
                ->update([
                    'name_type_work' => $re->input('name_type_work')
                ]);
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    public function typeWorkDelete(Request $re){
        $type_work = TypeWork::where('id', '=', $re->input('name_type_work_id'))
        ->withCount('work_kind')
        ->with('work_kind.work.plan_work')
        ->first();

        $cout_work = 0;

        if(isset($type_work->work_kind)){
            if(isset($type_work->work_kind->work)){
                if(isset($type_work->work_kind->work)){
                    foreach ($type_work->work_kind->work as $key => $value) {
                        if(isset($value->plan_work)){
                            $cout_work += $value->plan_work->count();
                        }
                    }
                }
            }
        }
        if($cout_work != 0){
            return back()
            ->with(['noDelete' => 'Ви не можете видалити цей тип роботи, тому що в системі існують роботи, який використовують цей тип роботи! Видаліть їх, або оголосіте щоб користувачі змінили тип роботи.']);
        }else{
            // delete work all
            if(isset($type_work->work_kind)){
                if(isset($type_work->work_kind->work)){
                    foreach ($type_work->work_kind->work as $work_item) {
                        $work_item->delete();
                    }
                }
            }
            // delete work group
            if(isset($type_work->work_kind)){
                $type_work->work_kind->delete();
            }
            // delete type work
            $type_work->delete();
            return back();
        }
        return back();
    }
    public function typeWorkNew(Request $re){
        try {
            $post = new TypeWork;
            $post->name_type_work = $re->input('name_type_work');
            $post->save();
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    public function workGroupShow(Request $req, $id){

        $groupWorks = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortGroupWork::sort($req, $id);
            $groupWorks =$val['value']; $get_req = $val['get'];
        }else{
            $groupWorks = WorkKind::where('type_work_id', '=', $id)
            ->with('work')
            ->paginate(15);
        }
        try {
            $type_work = TypeWork::where('id', '=', $id)->first();
            $type_work_name = $type_work->name_type_work;
            $type_work_id = $type_work->id;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('administrator.group-work', compact('groupWorks', 'get_req', 'type_work_name', 'type_work_id'));
    }
    public function workGroupEdit(Request $re){
        try {
            WorkKind::where('id', '=', $re->input('id'))
                ->update([
                    'kind_name' => $re->input('kind_name'),
                    'type_work_id' => $re->input('type_work_id')
                ]);
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }
    public function workGroupDelete(Request $re){
        $type_work = WorkKind::where('id', '=', $re->input('kind_work_id'))
        ->with('work.plan_work')
        ->first();

        $cout_work = 0;

            if(isset($type_work->work)){
                    foreach ($type_work->work as $key => $value) {
                        if(isset($value->plan_work)){
                            $cout_work += $value->plan_work->count();
                        }
                    }
            }

        if($cout_work != 0){
            return back()
            ->with(['noDelete' => 'Ви не можете видалити цю групу, тому що в системі існують роботи, які використовують цю групу! Видаліть їх або оголосіте користувачам, щоб вони змінили групу робіт.']);
        }else{
            // delete work all
                if(isset($type_work->work)){
                    foreach ($type_work->work as $work_item) {
                        $work_item->delete();
                    }
                }
            // delete work group
            if(isset($type_work)){
                $type_work->delete();
            }
            return back();
        }
        return back();
    }
    public function workGroupNew(Request $re){
        try {
            $groupWork = new WorkKind;
            $groupWork->kind_name = $re->input('kind_name');
            $groupWork->type_work_id = $re->input('type_work_id');
            $groupWork->save();
        } catch (\Throwable $th) {
            return back();
        }
        return back();
    }

    public function worksShow(Request $req, $id){
        $Works = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortWork::sort($req, $id);
            $Works =$val['value']; $get_req = $val['get'];
        }else{
            $Works = Work::where('works_kinds_id', '=', $id)
            ->with('work_kind')
            ->paginate(15);
        }
        try {
            $group_work = WorkKind::where('id', '=', $id)->first();
            $group_work_name = $group_work->kind_name;
            $group_work_id = $group_work->id;
        } catch (\Throwable $th) {
            //throw $th;
        }
        return view('administrator.works', compact('Works', 'get_req', 'group_work_name', 'group_work_id'));

    }
    public function worksEdit(Request $re){

        $des = $re->input('description') ? $re->input('description') : '';
        $normPoint = $re->input('norm-point') ? $re->input('norm-point') : '0';
        $normHour = $re->input('norm-hour') ? $re->input('norm-hour') : '0';
        try {
            Work::where('id', '=', $re->input('id'))
                ->update([
                    'indicator' => $re->input('indicator'),
                    'norm_desc' => $re->input('norm_desc'),
                    'norm-point' => $normPoint,
                    'norm-hour' => $normHour,
                    'description' => $des
                ]);
        } catch (\Throwable $th) {
            return back();
        }
        return back();

    }
    public function worksDelete(Request $re){
        $type_work = Work::where('id', '=', $re->input('work_id'))
        ->with('plan_work')
        ->first();

        $cout_work = 0;

            if(isset($type_work->plan_work[0])){
                $cout_work = $type_work->plan_work->count();
            }

            if($cout_work != 0){
                return back()
                ->with(['noDelete' => 'Ви не можете видалити цей формат робіт , тому що в системі існують роботи, які використовують цю цей формат робіт! Видаліть їх або оголосіте користувачам, щоб вони змінили формат робіт.']);
            }else{
                // delete work group
                if(isset($type_work)){
                    $type_work->delete();
                }
                return back();
            }
            return back();
    }
    public function worksNew(Request $re){
        $work = new Work;

        $des = $re->input('description') ? $re->input('description') : '';
        $normPoint = $re->input('norm-point') ? $re->input('norm-point') : '0';
        $normHour = $re->input('norm-hour') ? $re->input('norm-hour') : '0';

        $work->number_indicator = 0;
        $work->works_kinds_id = $re->input('works_kinds_id');
        $work->indicator = $re->input('indicator');
        $work->norm_desc = $re->input('norm_desc');
        $work['norm-point'] = $normPoint;
        $work['norm-hour'] = $normHour;
        $work->description = $des;

        try {
            $work->save();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return back();
        }
        return back();
    }

    public function departmentAnalytics(Request $re, $dep_id){
        $count_work_good = 0;
        $count_work_time = 0;
        $old_date = 0;
        $dep_name = Departments::where('id', '=', $dep_id)->first()->departament_name;
        $employees = Employee::where('department_id', '=', $dep_id)->get();

        $user_id = '';
        if($re->input('user')){
            $user_id = $re->input('user');
        }else{
            if(isset($employees[0])){
                $user_id = $employees[0]->id;
            }else{
                $user_id = 0;
            }
        }

        if($re->input('val-date-1')){
            $resultDateFirst = DB::select("select month(created_at) as mn, count(*) as cont
            from plan_works
            where employee_id = ? and created_at >= ? + ?
            group by month(created_at)", array($user_id ,
            $re->input('val-date-1'),
            $re->input('val-date-2')));
        }else{
            $resultDateFirst = DB::select("select month(created_at) as mn, count(*) as cont
            from plan_works
            where employee_id = ? and created_at >= '2020-01-12' + '2020-02-12'
            group by month(created_at)", array($user_id ));
        }
       try {
        $old_date = PlanWork::where([
            'employee_id' => $user_id,
            'status' => 1
            ])
            ->select('created_at')
            ->orderBy('created_at', 'asc')
            ->first()->created_at->format('Y-m-d');

        $max_date = PlanWork::where([
            'employee_id' => $user_id,
            'status' => 1
            ])
            ->select('created_at')
            ->orderBy('created_at', 'desc')
            ->first()->created_at->format('Y-m-d');

       } catch (\Throwable $th) {
        $old_date = '';
        $max_date = '';
       }
       $select_user = $user_id;
       if($re->input('select')){
        $select_user = $re->input('user-area');
        $isSelected = true;
       }else{
           $isSelected = false;
       }
        $allTypeWork = TypeWork::all();
        $type_work_count = array();
        foreach ($allTypeWork as $item) {
            $count = DB::select("
                SELECT count(*) as cn FROM plan_works
                LEFT JOIN works on plan_works.work_id = works.id
                LEFT JOIN works_kinds ON works.works_kinds_id = works_kinds.id
                LEFT JOIN `type-works` ON works_kinds.type_work_id =  `type-works`.id
                WHERE plan_works.employee_id = ? AND `type-works`.name_type_work = ?
            ", array($select_user, $item->name_type_work));

            $type_work_count[$item->name_type_work] = $count[0]->cn;
        }
        $count_work = PlanWork::where('departament_id', '=', $dep_id)->count();
        $count_people = Employee::where('department_id', '=', $dep_id)->count();
        $count_req = AccountCreationRequest::where('departament', '=', $dep_id)->count();
        return view('administrator.analytics', compact('dep_name','count_req', 'count_people', 'count_work', 'isSelected', 'employees', 'type_work_count', 'resultDateFirst', 'max_date', 'count_work_good', 'count_work_time','old_date'));

    }
}
