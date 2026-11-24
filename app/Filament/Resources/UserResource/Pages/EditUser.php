<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function beforeFill(): void
    {
        $this->record->makeVisible(['registered_at', 'referrer']);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        unset($data['github_access_token'], $data['remember_token']);

        return array_merge($data, [
            'is_registered' => $this->record->is_registered,
            'is_superadmin' => $this->record->is_superadmin,
            'is_blocked' => $this->record->is_blocked,
        ]);
    }
}
