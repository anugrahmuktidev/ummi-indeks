<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HasCorrectAnswer implements Rule
{
    protected string $message = 'Minimal satu jawaban harus ditandai sebagai kunci.';

    public function passes($attribute, $value): bool
    {
        if (! is_array($value) || count($value) < 2) {
            $this->message = 'Minimal dua pilihan jawaban diperlukan.';

            return false;
        }

        $hasKey = collect($value)->contains(function ($item): bool {
            return (bool) data_get($item, 'kunci_jawaban', false);
        });

        return $hasKey;
    }

    public function message(): string
    {
        return $this->message;
    }
}
