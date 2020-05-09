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
}
