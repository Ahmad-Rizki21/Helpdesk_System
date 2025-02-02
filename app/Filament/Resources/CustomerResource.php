<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Data Pelanggan';

    protected static ?string $navigationGroup = 'Helpdesk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Pelanggan'),
                Forms\Components\TextInput::make('customer_id')
                    ->required()
                    ->label('ID Pelanggan'),
                Forms\Components\TextInput::make('ip_address')
                    ->required()
                    ->label('IP Address'),
                Forms\Components\Select::make('service')
                    ->required()
                    ->label('Layanan')
                    ->options([
                        'ISP-JELANTIK' => 'ISP-JELANTIK',
                        'ISP-JAKINET' => 'ISP-JAKINET',
                    ])
                    ->placeholder('Pilih Layanan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('No')->sortable(), // Menggunakan id sebagai kolom No dan sortable
                Tables\Columns\TextColumn::make('name')->label('Nama Pelanggan')->searchable(),
                Tables\Columns\TextColumn::make('customer_id')->label('ID Pelanggan')->searchable(),
                Tables\Columns\TextColumn::make('ip_address')->label('IP Address')->searchable(),
                Tables\Columns\TextColumn::make('service')->label('Layanan')->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function afterCreate($record)
    {
        // Menyimpan kombinasi data
        $record->composite_data = "{$record->name} - {$record->customer_id} - {$record->ip_address}";
        $record->save();
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}