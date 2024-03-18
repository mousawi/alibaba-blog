<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected function mutateFormDataBeforeFill(array $data): array
    {
        unset($data['is_admin']);

        return $data;
    }
}
