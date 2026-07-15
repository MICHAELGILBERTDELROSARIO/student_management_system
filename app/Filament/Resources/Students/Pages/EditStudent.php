<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditStudent extends EditRecord
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($record, $data) {
            $record->update($data);

            if ($record->user) {
                $record->user->update([
                    'name' => trim($data['first_name'].' '.$data['last_name']),
                    'email' => $data['email'],
                ]);

                if (! empty($data['password'])) {
                    $record->user->update(['password' => $data['password']]);
                }
            }

            return $record;
        });
    }
}
