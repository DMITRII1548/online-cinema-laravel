<?php

declare(strict_types=1);

namespace App\Http\Requests\Movie;

use App\DTOs\Movie\FormMovieDTO;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:10000',
            'image' => 'nullable|image',
            'video_id' => 'required|integer|exists:videos,id|unique:movies,video_id',
        ];
    }

    public function toDTO(): FormMovieDTO
    {
        return FormMovieDTO::fromArray($this->validated());
    }
}
