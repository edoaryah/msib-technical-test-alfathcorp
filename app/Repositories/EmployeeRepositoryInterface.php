<?php

namespace App\Repositories;

use App\Models\Employee;

interface EmployeeRepositoryInterface
{
    /**
     * Menyimpan data karyawan baru.
     *
     * @param array $data
     * @return Employee
     */
    public function createEmployee(array $data): Employee;

    /**
     * Mengambil data karyawan berdasarkan ID.
     *
     * @param int $id
     * @return Employee|null
     */
    public function getEmployeeById(int $id): ?Employee;

    /**
     * Mengambil semua data karyawan.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllEmployees();

    /**
     * Memeriksa apakah karyawan dengan nama tertentu sudah ada.
     *
     * @param string $name
     * @return bool
     */
    public function employeeExistsByName(string $name): bool;
}
