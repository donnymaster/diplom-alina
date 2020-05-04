<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class NewWorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'norma-1-plane.required' => 'Ви не вказали норму для першого семестру за планом',
            'norma-1-plane.numeric' => 'Норма для першого семестру повинна бути записано у вигляді числа',
            'norma-2-plane.required' => 'Ви не вказали норму для другого семестру за планом',
            'norma-2-plane.numeric' => 'Норма для другого семестру повинна бути записано у вигляді числа',
            'count-plane.required' => 'Ви не вказали кількість за планом',
            'count-plane.numeric' => 'Кількість за планом має бути записано у вигляді числа',
            'share-plane.required' => 'Ви не вказали частку за планом',
            'share-plane.numeric' => 'Частка за планом повинна бути числом',
            'norma-1-fact.required' => 'Ви не вказали норму по першому семестру за фактом',
            'norma-1-fact.numeric' => 'Норма за фактом для першого семестру повинна бути записана у вигляді числа',
            'norma-2-fact.required' => 'Ви не вказали норму для другого семестру за фактом',
            'norma-2-fact.numeric' => 'Норма за фактом для другого семестру повинна бути записана у вигляді числа',
            'share-fact.required' => 'Ви не вказали частку за фактом',
            'share-fact.numeric' => 'Частка за фактом повинна бути записана у вигляді числа',
            'work.required' => 'Ви не вказали різновид роботи',
            'work.exists' => 'Такий різновиди роботи не існує',
            'work-title.required' => 'Ви не вказали назву роботи',
            'work-title.min' => 'Мінімальна довжина назви роботи становить 6 символів',
            'work-title.max' => 'Максимальна довжина назви роботи 255 символів',
            'desc-work.required' => 'Ви не вказали опису роботи',
            'desc-work.min' => 'Мінімальна довжина опису роботи 6 символів',
            'desc-work.max' => 'Максимальна довжина опису становить: 65535 символів'


        ];
    }
    public function rules()
    {
        return [
            'work' => 'required|exists:works,id',
            'work-title' => 'required|min:6|max:255',
            'desc-work' => 'required|min:6|max:65535',
            'category_work' => 'string',
            'user-count' => 'required',
            'departament' => 'required|string',
            'status' => 'string'

        ];
    }
}
