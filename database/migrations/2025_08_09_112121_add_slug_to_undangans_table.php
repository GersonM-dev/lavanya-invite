<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('undangans', function (Blueprint $table) {
            $table->string('slug')->unique()->after('email');
        });

        // backfill slugs for existing rows
        DB::table('undangans')->orderBy('id')->chunkById(200, function ($rows) {
            foreach ($rows as $row) {
                $base = Str::slug(trim(($row->nama_panggilan_wanita ?? '').'-'.($row->nama_panggilan_pria ?? 'undangan')));
                if ($base === '') $base = 'undangan';
                $slug = $base; $i = 1;
                while (DB::table('undangans')->where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i++;
                }
                DB::table('undangans')->where('id', $row->id)->update(['slug' => $slug]);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('undangans', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
