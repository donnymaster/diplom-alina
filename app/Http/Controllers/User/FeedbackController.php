<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SendMessageUserRequest;
use App\Services\UserMessage;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('user.feedback');
    }

    public function store(SendMessageUserRequest $request)
    {
        $validated = $request->validated();

        if(UserMessage::send($validated, $request, Auth::user()->id)){
            return redirect()
                    ->route('user.feedback')
                    ->with(['successFeedback' => 'Ваше повідомлення надіслано.']);
        }else{
            return redirect()
                    ->route('user.feedback')
                    ->with(['successFeedback' => 'Вибачте сталася помилка :( Зверніться до адміністратора.']);
        }
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
