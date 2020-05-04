<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FeedbackAnser;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user_id = Auth::user()->id;
        $get_req = array();

        if($request->input('value') && $request->input('type-sort')){
            switch ($request->input('value')) {
                case '1':
                        if($request->input('type-sort') == 'desc'){
                            $answers = FeedbackAnser::orderBy('asked_user_read', 'desc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 1; $get_req['type']= 'desc';
                        }else{
                            $answers = FeedbackAnser::orderBy('asked_user_read', 'asc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 1; $get_req['type']= 'asc';
                        }
                    break;
                case '2':
                        if($request->input('type-sort') == 'desc'){
                            $answers = FeedbackAnser::orderBy('created_at', 'desc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 2; $get_req['type']= 'desc';
                        }else{
                            $answers = FeedbackAnser::orderBy('created_at', 'asc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 2; $get_req['type']= 'asc';
                        }
                    break;
                default:
                    # code...
                    break;
            }
        }else{
        $answers = FeedbackAnser::orderBy('id', 'desc')
            ->where('asked_user', '=', $user_id)
            ->with('user_answered', 'feedback')
            ->paginate(15);
        }


        if($answers->count() == 0){ // записи отсутствуют
            return view('user.my-message', ['noMessage' => 'Повідомлення відсутні']);
        }else{
            $count_no_read = FeedbackAnser::where([['asked_user_read', '=', false],['asked_user', '=', $user_id]])->count();

            return view('user.my-message', compact('answers', 'count_no_read', 'get_req'));
        }
    }

    public function deleteAllMessage(Request $request){

        $user_id = Auth::user()->id;

        try {
            FeedbackAnser::where('asked_user', '=', $user_id)->delete();
        } catch (\Throwable $th) {
            return back()->with(['errorDeleteAll' => $th->getMessage()]);
        }
        if(Auth::user()->role->role_name == 'user'){
            return redirect()->route('user.message')->with(['successDeleteAll' => 'Повідомлення видалені!']);
        }elseif(Auth::user()->role->role_name == 'moderator'){
            return redirect()->route('moderator.myMessage')->with(['successDeleteAll' => 'Повідомлення видалені!']);
        }
    }


    public function changeStatusMessage(Request $request, $id){

        $user_id = Auth::user()->id;

        if(FeedbackAnser::where([
            ['asked_user', '=', $user_id],
            ['id', '=', $id ]
        ])->count() != 0){
            FeedbackAnser::where('id', '=', $id)->update(['asked_user_read' => true]);
        }
    }

    public function deleteMessage(Request $request, $id){
        $user_id = Auth::user()->id;

        if(FeedbackAnser::where([
            ['asked_user', '=', $user_id],
            ['id', '=', $id ]
        ])->count() != 0){
            FeedbackAnser::where('id', '=', $id)->delete();
            if(Auth::user()->role->role_name == 'user'){
                return redirect()->route('user.message');
            }elseif(Auth::user()->role->role_name == 'moderator'){
                return redirect()->route('moderator.myMessage');
            }
        }else{
            if(Auth::user()->role->role_name == 'user'){
                return redirect()->route('user.message');
            }elseif(Auth::user()->role->role_name == 'moderator'){
                return redirect()->route('moderator.myMessage');
            }
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
