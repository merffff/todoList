<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название задачи обязательно для заполнения',
            'title.string' => 'Название задачи должно быть строкой',
            'title.max' => 'Название задачи не должно превышать 255 символов',
            'description.string' => 'Описание задачи должно быть строкой',
            'status.in' => 'Статус должен быть одним из следующих: pending, in_progress, completed',
        ];
    }
}

