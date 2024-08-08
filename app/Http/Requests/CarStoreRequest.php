<?php

namespace App\Http\Requests;

use App\Models\Car;
use Illuminate\Foundation\Http\FormRequest;

class CarStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand' => ['required', 'string'],
            'model' => ['required', 'string', 'unique:cars'],
            'year' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'manufacturing' => ['required', 'integer']
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $modelAttribute = $this->input('model');

            $model = Car::withTrashed()->where('model', $modelAttribute)->first();
            if ($model && $model->trashed()) {
                $model->restore();
                $model->update(['brand', 'year', 'price', 'manufacturing']);
                return redirect()->route('car.index')->with('success', 'Car restored successfully!');
            }
        });
    }
}
