<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClipboardResource\Pages;
use App\Filament\Resources\ClipboardResource\RelationManagers;
use App\Models\Clipboard;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;

class ClipboardResource extends Resource
{
    protected static ?string $model = Clipboard::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Textarea::make('content')
                    ->label('Content')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordUrl(null)
            ->actions([
                CopyAction::make()->copyable(fn ($record) => $record->content),
                Tables\Actions\ViewAction::make()
                    ->modalFooterActions([
                        CopyAction::make()->copyable(fn ($record) => $record->content),
                        Tables\Actions\EditAction::make(),
                        Tables\Actions\DeleteAction::make(),
                    ]),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListClipboards::route('/'),
            'create' => Pages\CreateClipboard::route('/create'),
            'edit' => Pages\EditClipboard::route('/{record}/edit'),
        ];
    }
}
