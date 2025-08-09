<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUndangansTable extends Migration
{
    public function up()
    {
        Schema::create('undangans', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('nama_panggilan_pria')->nullable();
            $table->string('nama_panggilan_wanita')->nullable();
            $table->text('quotes')->nullable();

            // Pengantin wanita
            $table->string('ig_wanita')->nullable();
            $table->string('nama_lengkap_wanita')->nullable();
            $table->string('anak_ke_wanita')->nullable();
            $table->string('nama_ayah_wanita')->nullable();
            $table->string('nama_ibu_wanita')->nullable();

            // Pengantin pria
            $table->string('ig_pria')->nullable();
            $table->string('nama_lengkap_pria')->nullable();
            $table->string('anak_ke_pria')->nullable();
            $table->string('nama_ayah_pria')->nullable();
            $table->string('nama_ibu_pria')->nullable();

            // Detail acara
            $table->date('tanggal_acara')->nullable();
            $table->text('alamat_lokasi_acara')->nullable();
            $table->string('link_google_maps')->nullable();

            // Pemberkatan
            $table->date('tanggal_pemberkatan')->nullable();
            $table->string('pemberkatan_mulai')->nullable();
            $table->string('pemberkatan_selesai')->nullable();

            // Resepsi
            $table->date('tanggal_resepsi')->nullable();
            $table->string('resepsi_mulai')->nullable();
            $table->string('resepsi_selesai')->nullable();

            // Turut mengundang (optional)
            $table->string('turut_mengundang_1')->nullable();
            $table->string('turut_mengundang_2')->nullable();

            // Story (optional, contoh untuk 1 story)
            $table->string('story_judul_1')->nullable();
            $table->text('story_cerita_1')->nullable();
            $table->string('story_photo_1')->nullable();

            // Foto (link/nama file)
            $table->string('photo_cover_1')->nullable();
            $table->string('photo_cover_2')->nullable();
            $table->string('photo_cover_3')->nullable();

            $table->string('photo_berdua_1')->nullable();
            $table->string('photo_berdua_2')->nullable();
            $table->string('photo_berdua_3')->nullable();

            $table->string('photo_profile_pria_1')->nullable();
            $table->string('photo_profile_pria_2')->nullable();
            $table->string('photo_profile_pria_3')->nullable();

            $table->string('photo_profile_wanita_1')->nullable();
            $table->string('photo_profile_wanita_2')->nullable();
            $table->string('photo_profile_wanita_3')->nullable();

            // Gallery (bisa extend, di sini hanya 5 untuk contoh)
            $table->string('photo_gallery_1')->nullable();
            $table->string('photo_gallery_2')->nullable();
            $table->string('photo_gallery_3')->nullable();
            $table->string('photo_gallery_4')->nullable();
            $table->string('photo_gallery_5')->nullable();

            // Rekening Amplop (contoh 2)
            $table->string('no_rek_amplop_1')->nullable();
            $table->string('no_rek_amplop_2')->nullable();

            $table->string('background_musik')->nullable();
            $table->string('link_design')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('undangans');
    }
}
