<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * Menyimpan data karyawan baru.
     *
     * @param array $data
     * @return Employee
     */
    public function createEmployee(array $data): Employee
    {
        return Employee::create($data);
    }

    /**
     * Mengambil data karyawan berdasarkan ID.
     *
     * @param int $id
     * @return Employee|null
     */
    public function getEmployeeById(int $id): ?Employee
    {
        return Employee::find($id);
    }

    /**
     * Mengambil semua data karyawan.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllEmployees()
    {
        return Employee::all();
    }

    /**
     * Memeriksa apakah karyawan dengan nama tertentu sudah ada.
     *
     * @param string $name
     * @return bool
     */
    public function employeeExistsByName(string $name): bool
    {
        return Employee::where('name', $name)->exists();
    }
}
