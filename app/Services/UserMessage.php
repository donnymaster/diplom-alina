<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class UserMessage{

    public static function send($validated, $request, $user_id = null){

        $message = new Feedback;
        $message->title = $validated['tema'];
        $message->user_id = $user_id;
        $message->content = $validated['content'];
        $message->type_user = $validated['type-user'];
        $message->departament_id = Auth::user()->employee->department_id;

        if($request->file('attachment')){
            $files = new AddFileService($request->file('attachment'));
            $json = $files->sendFileToFolder('feedback');
            $message->materials = json_encode($json);
        }
        if($message->save()){
            return true;
        }else{
            return false;
        }
    }
}
