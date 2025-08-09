<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UndanganResource\Pages;
use App\Filament\Resources\UndanganResource\RelationManagers;
use App\Models\Undangan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UndanganResource extends Resource
{
    protected static ?string $model = Undangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Utama')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        Forms\Components\TextInput::make('nama_panggilan_pria')->label('Nama Panggilan Pria'),
                        Forms\Components\TextInput::make('nama_panggilan_wanita')->label('Nama Panggilan Wanita'),
                        Forms\Components\Textarea::make('quotes')->label('Quotes'),
                    ]),

                Forms\Components\Section::make('Pengantin Wanita')
                    ->schema([
                        Forms\Components\TextInput::make('ig_wanita')->label('IG Wanita'),
                        Forms\Components\TextInput::make('nama_lengkap_wanita')->label('Nama Lengkap Wanita'),
                        Forms\Components\TextInput::make('anak_ke_wanita')->label('Anak ke- (Wanita)'),
                        Forms\Components\TextInput::make('nama_ayah_wanita')->label('Nama Ayah Wanita'),
                        Forms\Components\TextInput::make('nama_ibu_wanita')->label('Nama Ibu Wanita'),
                    ]),

                Forms\Components\Section::make('Pengantin Pria')
                    ->schema([
                        Forms\Components\TextInput::make('ig_pria')->label('IG Pria'),
                        Forms\Components\TextInput::make('nama_lengkap_pria')->label('Nama Lengkap Pria'),
                        Forms\Components\TextInput::make('anak_ke_pria')->label('Anak ke- (Pria)'),
                        Forms\Components\TextInput::make('nama_ayah_pria')->label('Nama Ayah Pria'),
                        Forms\Components\TextInput::make('nama_ibu_pria')->label('Nama Ibu Pria'),
                    ]),

                Forms\Components\Section::make('Detail Acara')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_acara')->label('Tanggal Acara'),
                        Forms\Components\Textarea::make('alamat_lokasi_acara')->label('Alamat Lokasi Acara'),
                        Forms\Components\TextInput::make('link_google_maps')->label('Link Google Maps'),
                    ]),

                Forms\Components\Section::make('Pemberkatan')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_pemberkatan')->label('Tanggal Pemberkatan'),
                        Forms\Components\TextInput::make('pemberkatan_mulai')->label('Pemberkatan Mulai'),
                        Forms\Components\TextInput::make('pemberkatan_selesai')->label('Pemberkatan Selesai'),
                    ]),

                Forms\Components\Section::make('Resepsi')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_resepsi')->label('Tanggal Resepsi'),
                        Forms\Components\TextInput::make('resepsi_mulai')->label('Resepsi Mulai'),
                        Forms\Components\TextInput::make('resepsi_selesai')->label('Resepsi Selesai'),
                    ]),

                Forms\Components\Section::make('Turut Mengundang')
                    ->schema([
                        Forms\Components\TextInput::make('turut_mengundang_1')->label('Turut Mengundang 1'),
                        Forms\Components\TextInput::make('turut_mengundang_2')->label('Turut Mengundang 2'),
                    ]),

                Forms\Components\Section::make('Story')
                    ->schema([
                        Forms\Components\TextInput::make('story_judul_1')->label('Story Judul 1'),
                        Forms\Components\Textarea::make('story_cerita_1')->label('Story Cerita 1'),
                        Forms\Components\FileUpload::make('story_photo_1')->label('Story Photo 1'),
                    ]),

                Forms\Components\Section::make('Foto Cover')
                    ->schema([
                        Forms\Components\FileUpload::make('photo_cover_1')->label('Photo Cover 1'),
                        Forms\Components\FileUpload::make('photo_cover_2')->label('Photo Cover 2'),
                        Forms\Components\FileUpload::make('photo_cover_3')->label('Photo Cover 3'),
                    ]),

                Forms\Components\Section::make('Foto Berdua')
                    ->schema([
                        Forms\Components\FileUpload::make('photo_berdua_1')->label('Photo Berdua 1'),
                        Forms\Components\FileUpload::make('photo_berdua_2')->label('Photo Berdua 2'),
                        Forms\Components\FileUpload::make('photo_berdua_3')->label('Photo Berdua 3'),
                    ]),

                Forms\Components\Section::make('Photo Profile Pria')
                    ->schema([
                        Forms\Components\FileUpload::make('photo_profile_pria_1')->label('Photo Profile Pria 1'),
                        Forms\Components\FileUpload::make('photo_profile_pria_2')->label('Photo Profile Pria 2'),
                        Forms\Components\FileUpload::make('photo_profile_pria_3')->label('Photo Profile Pria 3'),
                    ]),

                Forms\Components\Section::make('Photo Profile Wanita')
                    ->schema([
                        Forms\Components\FileUpload::make('photo_profile_wanita_1')->label('Photo Profile Wanita 1'),
                        Forms\Components\FileUpload::make('photo_profile_wanita_2')->label('Photo Profile Wanita 2'),
                        Forms\Components\FileUpload::make('photo_profile_wanita_3')->label('Photo Profile Wanita 3'),
                    ]),

                Forms\Components\Section::make('Gallery')
                    ->schema([
                        Forms\Components\FileUpload::make('photo_gallery_1')->label('Photo Gallery 1'),
                        Forms\Components\FileUpload::make('photo_gallery_2')->label('Photo Gallery 2'),
                        Forms\Components\FileUpload::make('photo_gallery_3')->label('Photo Gallery 3'),
                    ]),

                Forms\Components\Section::make('Rekening Amplop')
                    ->schema([
                        Forms\Components\TextInput::make('no_rek_amplop_1')->label('No Rek Amplop 1'),
                        Forms\Components\TextInput::make('no_rek_amplop_2')->label('No Rek Amplop 2'),
                    ]),

                Forms\Components\Section::make('Lain-lain')
                    ->schema([
                        Forms\Components\TextInput::make('background_musik')->label('Background Musik (Link/Title)'),
                        Forms\Components\TextInput::make('link_design')->label('Link Design'),
                        Forms\Components\Textarea::make('catatan')->label('Catatan'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('nama_panggilan_pria'),
                Tables\Columns\TextColumn::make('nama_panggilan_wanita'),
                Tables\Columns\TextColumn::make('tanggal_acara')->date(),
                Tables\Columns\TextColumn::make('tanggal_resepsi')->date(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUndangans::route('/'),
            'create' => Pages\CreateUndangan::route('/create'),
            'edit' => Pages\EditUndangan::route('/{record}/edit'),
        ];
    }
}
