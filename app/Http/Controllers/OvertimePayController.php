<?php

namespace App\Http\Controllers;

use App\Repositories\OvertimeRepositoryInterface;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/api/overtime-pays/calculate",
 *     summary="Calculate overtime pay",
 *     tags={"Overtime Pay"},
 *     @OA\Parameter(
 *         name="month",
 *         in="query",
 *         required=true,
 *         @OA\Schema(type="string", format="YYYY-MM")
 *     ),
 *     @OA\Response(response="200", description="Overtime pay calculated successfully"),
 *     @OA\Response(response="422", description="Validation error")
 * )
 */
class OvertimePayController extends Controller
{
    private OvertimeRepositoryInterface $overtimeRepository;

    public function __construct(OvertimeRepositoryInterface $overtimeRepository)
    {
        $this->overtimeRepository = $overtimeRepository;
    }

    /**
     * Menghitung pembayaran lembur berdasarkan bulan yang diberikan.
     *
     * @return JsonResponse
     */
    public function calculate(): JsonResponse
    {
        $month = request()->get('month');

        // Validasi format bulan
        if (!$this->isValidMonthFormat($month)) {
            return response()->json([
                'message' => 'Invalid month format. Use YYYY-MM.',
            ], 400);
        }

        $overtimePays = $this->overtimeRepository->calculateOvertimePay($month);

        return response()->json($overtimePays, 200);
    }

    /**
     * Memeriksa format bulan yang valid (YYYY-MM).
     *
     * @param string $month
     * @return bool
     */
    private function isValidMonthFormat(string $month): bool
    {
        return preg_match('/^\d{4}-\d{2}$/', $month);
    }
}
