<?php

declare(strict_types=1);

namespace App\Http\Requests\Video;

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
            'video' => 'required|file|max:10240',
        ];
    }

    public function toDTO(): FormVideoDTO
    {
        return FormVideoDTO::fromArray($this->validated());
    }
}
