<?php

// app/Models/Undangan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Undangan extends Model
{
    protected $fillable = [
        'email','slug',
        'nama_panggilan_pria','nama_panggilan_wanita','quotes',
        'ig_wanita','nama_lengkap_wanita','anak_ke_wanita','nama_ayah_wanita','nama_ibu_wanita',
        'ig_pria','nama_lengkap_pria','anak_ke_pria','nama_ayah_pria','nama_ibu_pria',
        'tanggal_acara','alamat_lokasi_acara','link_google_maps',
        'tanggal_pemberkatan','pemberkatan_mulai','pemberkatan_selesai',
        'tanggal_resepsi','resepsi_mulai','resepsi_selesai',
        'turut_mengundang_1','turut_mengundang_2',
        'story_judul_1','story_cerita_1','story_photo_1',
        'photo_cover_1','photo_cover_2','photo_cover_3',
        'photo_berdua_1','photo_berdua_2','photo_berdua_3',
        'photo_profile_pria_1','photo_profile_pria_2','photo_profile_pria_3',
        'photo_profile_wanita_1','photo_profile_wanita_2','photo_profile_wanita_3',
        'photo_gallery_1','photo_gallery_2','photo_gallery_3','photo_gallery_4','photo_gallery_5',
        'no_rek_amplop_1','no_rek_amplop_2',
        'background_musik','link_design','catatan',
    ];

    protected $casts = [
        'tanggal_acara' => 'date',
        'tanggal_pemberkatan' => 'date',
        'tanggal_resepsi' => 'date',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::creating(function ($m) {
            if (empty($m->slug)) {
                $base = Str::slug(trim(($m->nama_panggilan_wanita ?? '').'-'.($m->nama_panggilan_pria ?? 'undangan')));
                if ($base === '') $base = 'undangan';
                $slug = $base; $i = 1;
                while (static::where('slug', $slug)->exists()) $slug = $base.'-'.$i++;
                $m->slug = $slug;
            }
        });
    }
}
