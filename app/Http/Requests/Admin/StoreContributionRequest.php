<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreContributionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'finance']);
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'contribution_date' => ['required', 'date'],
        ];
    }
}
