<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'description' => 'nullable|string',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ];

        if ($this->isMethod('POST')) {
            $rules['title'] = 'required|string|max:255';
        } else {
            $rules['title'] = 'sometimes|required|string|max:255';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название задачи обязательно',
            'title.max' => 'Название задачи не должно превышать 255 символов',
            'status.in' => 'Статус должен быть одним из: pending, in_progress, completed',
        ];
    }
}
