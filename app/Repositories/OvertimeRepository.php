<?php

namespace App\Repositories;

use App\Models\Overtime;
use App\Models\Employee;
use App\Models\Reference;
use App\Models\Setting;
use App\Repositories\OvertimeRepositoryInterface;

class OvertimeRepository implements OvertimeRepositoryInterface
{
    /**
     * Menyimpan data lembur baru.
     *
     * @param array $data
     * @return Overtime
     */
    public function createOvertime(array $data): Overtime
    {
        return Overtime::create($data);
    }

    /**
     * Mengambil data lembur berdasarkan ID.
     *
     * @param int $id
     * @return Overtime|null
     */
    public function getOvertimeById(int $id): ?Overtime
    {
        return Overtime::find($id);
    }

    /**
     * Mengambil semua data lembur untuk karyawan tertentu dalam bulan tertentu.
     *
     * @param int $employeeId
     * @param string $month
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getOvertimeByEmployeeAndMonth(int $employeeId, string $month)
    {
        return Overtime::where('employee_id', $employeeId)
            ->whereMonth('date', date('m', strtotime($month)))
            ->whereYear('date', date('Y', strtotime($month)))
            ->get();
    }

    /**
     * Menghitung total upah lembur untuk setiap karyawan berdasarkan bulan yang ditentukan.
     *
     * @param string $month
     * @return array
     */
    public function calculateOvertimePay(string $month): array
    {
        $employees = Employee::all();
        $overtimeMethodId = Setting::where('key', 'overtime_method')->value('value');
        $overtimeMethod = Reference::find($overtimeMethodId)->expression;

        $results = [];

        foreach ($employees as $employee) {
            $overtimes = $this->getOvertimeByEmployeeAndMonth($employee->id, $month);
            $overtimeDurationTotal = 0;

            foreach ($overtimes as $overtime) {
                $start = strtotime($overtime->time_started);
                $end = strtotime($overtime->time_ended);
                $duration = floor(($end - $start) / 3600); // Menghitung durasi lembur dalam jam
                $overtime->overtime_duration = $duration;
                $overtimeDurationTotal += $duration;
            }

            $amount = eval('return ' . str_replace('overtime_duration_total', $overtimeDurationTotal, $overtimeMethod) . ';');

            $results[] = [
                'id' => $employee->id,
                'name' => $employee->name,
                'salary' => $employee->salary,
                'overtimes' => $overtimes,
                'overtime_duration_total' => $overtimeDurationTotal,
                'amount' => $amount,
            ];
        }

        return $results;
    }
}
