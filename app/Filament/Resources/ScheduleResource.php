<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("title")
                    ->label("Kegiatan")
                    ->required()
                    ->columnSpan("full")
                    ->maxLength(255),
                DateTimePicker::make("start")
                    ->label("Mulai")
                    ->required()
                    ->seconds(false)
                    ->rules([
                        fn (Get $get) => function ($attribute, $value, $fail) use ($get) {
                            $overlapped = static::$model::where(function (Builder $query) use ($value) {
                                $query->where("title", $value);
                            })->where(function (Builder $query) use ($get) {
                                $query->where("start", "<=", $get("start"))
                                    ->where("end", ">=", $get("start"));
                            })->orWhere(function (Builder $query) use ($get) {
                                $query->where("start", "<=", $get("end"))
                                    ->where("end", ">=", $get("end"));
                            })->exists();
                            if ($overlapped) {
                                $fail("Kegiatan ini sudah ada pada waktu yang sama");
                            }
                            if ($get("end") && $value >= $get("end")) {
                                $fail("Waktu mulai harus lebih kecil dari waktu selesai");
                            }
                        },
                    ]),
                DateTimePicker::make("end")
                    ->label("Selesai")
                    ->required()
                    ->seconds(false),
                Textarea::make("description")
                    ->label("Deskripsi")
                    ->columnSpan('full')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title")
                    ->label("Kegiatan")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("start")
                    ->label("Mulai")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("end")
                    ->label("Selesai")
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordUrl(null)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->requiresConfirmation(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
