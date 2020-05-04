<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewWorkRequest;
use App\Models\PlanWork;
use App\Models\TypeWork;
use App\Models\Work;
use App\Models\WorkKind;
use App\Services\GetInfoUniversity;
use App\Services\MakeWorkService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlanWorkController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $employee = $user->employee->name . ' ' . $user->employee->surname . ' ' . $user->employee->patronymic;
        $facultyName = $user->employee->departament->faculty->faculty_name;
        $departamentName =  $user->employee->departament->departament_name;
        $year = Carbon::now()->year;
        $date = Carbon::today()->toDateString();
        $work_kinds = WorkKind::all();
        $works = Work::all();
        $type_work = TypeWork::with('category_name.category_work')->get();

        $jsonWork = response()->json($works);
        $jsonWorkKinds = response()->json($work_kinds);
        $jsonTypeWork = response()->json($type_work);
        $allDep = response()->json(DB::select('select * from departments'));
        $facultes = DB::select('select * from facultes');

        return view('user.add-work', compact('facultes', 'allDep', 'works' ,'work_kinds','type_work' ,'employee', 'facultyName', 'departamentName', 'year', 'date', 'jsonWork', 'jsonWorkKinds', 'jsonTypeWork'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewWorkRequest $request)
    {
        $validated = $request->validated();
        $count_users_share = 0;
        $title_work = strtolower(trim($validated['work-title']));

        if($validated['user-count'] == 0){
            return redirect()->route('user.addWork');
        }

        $check_result = PlanWork::with('employee')
            ->where([
                'title' => $title_work,
                'work_id' => $validated['work']
            ])->get();

        if($check_result->count() == 0){
            MakeWorkService::make($validated, $request)->save();
            return redirect()
            ->route('user.addWork')
            ->with(['successWork' => 'Робота додана! На протязі декількох днів модератор обробить вашу роботу.']);
        }else{
            // подсчет количества долей
            $count_users_share = $check_result->reduce(function($current, $item){
                return $current + $item->user_count;
            });
            if($count_users_share < 1){
                if(($validated['user-count'] + $count_users_share) <= 1){
                    // создание работы
                    MakeWorkService::make($validated, $request)->save();
                    return redirect()
                    ->route('user.addWork')
                    ->with(['successWork' => 'Робота додана! На протязі декількох днів модератор обробить вашу роботу.']);
                    //dd('создаем работу');
                }else{
                    // вывод сообщения что нельзя и вывод тех кто делал эту работу
                    $error_messages = $check_result->map(function($item, $key){
                        return 'Дану роботу виконав '. $item->employee->name .' '
                                . $item->employee->surname .' і його частка ' . $item->user_count;
                    });
                    return redirect()
                    ->route('user.addWork')
                    ->with(['notAddWork' => $error_messages]);
                }
            }else{
                    // вывод сообщения что нельзя и вывод тех кто делал эту работу
                    $error_messages = $check_result->map(function($item, $key){
                        return 'Дану роботу виконав '. $item->employee->name .' '
                                . $item->employee->surname .' і його частка ' . $item->user_count;
                    });
                    return redirect()
                    ->route('user.addWork')
                    ->with(['notAddWork' => $error_messages]);
            }
        }
        return redirect()->route('user.addWork');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
