<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    /**
     * Mengambil nilai setting berdasarkan kunci.
     *
     * @param string $key
     * @return mixed
     */
    public function getSetting(string $key)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : null;
    }

    /**
     * Memperbarui nilai setting berdasarkan kunci.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function updateSetting(string $key, $value): bool
    {
        $setting = Setting::where('key', $key)->first();

        if ($setting) {
            $setting->value = $value;
            return $setting->save();
        }

        // Jika setting tidak ditemukan, buat entri baru
        return Setting::create([
            'key' => $key,
            'value' => $value,
        ]) ? true : false;
    }
}
