<?php

namespace App\Repositories;

interface SettingRepositoryInterface
{
    /**
     * Mengambil nilai setting berdasarkan kunci.
     *
     * @param string $key
     * @return mixed
     */
    public function getSetting(string $key);

    /**
     * Memperbarui nilai setting berdasarkan kunci.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function updateSetting(string $key, $value): bool;
}
