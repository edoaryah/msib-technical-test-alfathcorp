<?php

namespace App\Repositories;

use App\Models\Overtime;

interface OvertimeRepositoryInterface
{
    /**
     * Menyimpan data lembur baru.
     *
     * @param array $data
     * @return Overtime
     */
    public function createOvertime(array $data): Overtime;

    /**
     * Mengambil data lembur berdasarkan ID.
     *
     * @param int $id
     * @return Overtime|null
     */
    public function getOvertimeById(int $id): ?Overtime;

    /**
     * Mengambil semua data lembur untuk karyawan tertentu dalam bulan tertentu.
     *
     * @param int $employeeId
     * @param string $month
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOvertimeByEmployeeAndMonth(int $employeeId, string $month);

    /**
     * Menghitung total upah lembur untuk setiap karyawan berdasarkan bulan yang ditentukan.
     *
     * @param string $month
     * @return array
     */
    public function calculateOvertimePay(string $month): array;
}
