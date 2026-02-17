<?php

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\ProfileResource;
use App\Models\Profile;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListProfiles extends ListRecords
{
    protected static string $resource = ProfileResource::class;

    public function mount(): void
    {
        parent::mount();

        $profile = Profile::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'username' => $this->generateUsername(),
                'display_name' => auth()->user()?->name,
            ]
        );

        $this->redirect(ProfileResource::getUrl('edit', ['record' => $profile]));
    }

    protected function getHeaderActions(): array
    {
        return [];
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
