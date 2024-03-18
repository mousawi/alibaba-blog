<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Register as BaseRegister;

class Register extends BaseRegister
{
    protected function mutateFormDataBeforeFill(array $data): array
    {
        unset($data['is_admin']);

        return $data;
    }
}
