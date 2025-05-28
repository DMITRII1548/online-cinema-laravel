<?php

namespace App\Http\Requests\Movie;

use App\DTOs\Movie\FormMovieDTO;
use App\DTOs\Movie\MovieDTO;
use App\DTOs\Video\FormVideoDTO;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'image' => 'required|image',
            'video_id' => 'required|integer|exists:videos,id|unique:movies,video_id',
        ];
    }

    public function toDTO(): FormMovieDTO
    {
        return FormMovieDTO::fromArray($this->validated());
    }
}
