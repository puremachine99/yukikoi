<?php

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\ProfileResource;
use App\Models\Profile;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateProfile extends CreateRecord
{
    protected static string $resource = ProfileResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        if (blank($data['username'] ?? null)) {
            $data['username'] = $this->generateUsername();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function generateUsername(): string
    {
        $base = Str::slug(auth()->user()?->name ?? 'user', '');

        if ($base === '') {
            $base = 'user';
        }

        $candidate = $base;
        $suffix = 1;

        while (Profile::where('username', $candidate)->exists()) {
            $suffix++;
            $candidate = $base . $suffix;
        }

        return $candidate;
    }
}
