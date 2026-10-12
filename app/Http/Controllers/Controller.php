<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Mengambil waktu dari sisi klien/browser.
     *
     * Browser mengirim ISO-8601 lengkap dengan offset, contoh:
     * 2026-10-12T09:15:30+07:00
     *
     * Jika data tidak tersedia/tidak valid, gunakan waktu server sebagai
     * fallback agar proses aplikasi tidak gagal.
     */
    protected function clientNow(Request $request): Carbon
    {
        $clientDatetime = $request->input('client_datetime');

        if ($clientDatetime) {
            try {
                return Carbon::parse($clientDatetime);
            } catch (\Throwable $e) {
                // Fallback ke waktu server.
            }
        }

        return now();
    }
}
