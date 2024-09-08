<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOvertimeRequest;
use App\Repositories\OvertimeRepositoryInterface;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Post(
 *     path="/api/overtimes",
 *     summary="Create a new overtime entry",
 *     tags={"Overtimes"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="employee_id", type="integer", example=1, description="Must match the corresponding employees.id."),
 *             @OA\Property(property="date", type="string", format="date", example="2024-08-15", description="Cannot have the same date for the same employee_id."),
 *             @OA\Property(property="time_started", type="string", format="HH:mm", example="08:00", description="Cannot be later than time_ended."),
 *             @OA\Property(property="time_ended", type="string", format="HH:mm", example="17:00", description="Cannot be earlier than time_started.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Overtime created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="employee_id", type="integer", example=1),
 *             @OA\Property(property="date", type="string", format="date", example="2024-08-15"),
 *             @OA\Property(property="time_started", type="string", format="HH:mm", example="08:00"),
 *             @OA\Property(property="time_ended", type="string", format="HH:mm", example="17:00")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="employee_id", type="array", @OA\Items(type="string", example="The employee_id field is required.")),
 *                 @OA\Property(property="date", type="array", @OA\Items(type="string", example="The date has already been taken.")),
 *                 @OA\Property(property="time_started", type="array", @OA\Items(type="string", example="The time started must be before time ended.")),
 *                 @OA\Property(property="time_ended", type="array", @OA\Items(type="string", example="The time ended must be after time started."))
 *             )
 *         )
 *     )
 * )
 */
class OvertimeController extends Controller
{
    private OvertimeRepositoryInterface $overtimeRepository;

    public function __construct(OvertimeRepositoryInterface $overtimeRepository)
    {
        $this->overtimeRepository = $overtimeRepository;
    }

    /**
     * Menyimpan data lembur baru.
     *
     * @param StoreOvertimeRequest $request
     * @return JsonResponse
     */
    public function store(StoreOvertimeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $overtime = $this->overtimeRepository->createOvertime($data);

        return response()->json([
            'message' => 'Overtime created successfully.',
            'data' => $overtime,
        ], 201);
    }

    /**
     * Menghitung pembayaran lembur.
     *
     * @return JsonResponse
     */
    public function calculate(): JsonResponse
    {
        $month = request()->get('month');

        $overtimePays = $this->overtimeRepository->calculateOvertimePay($month);

        return response()->json($overtimePays, 200);
    }
}
