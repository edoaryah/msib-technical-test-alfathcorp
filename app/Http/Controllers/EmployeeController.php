<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Repositories\EmployeeRepositoryInterface;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Post(
 *     path="/api/employees",
 *     summary="Create a new employee",
 *     tags={"Employees"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", minLength=2, example="John Doe", description="Minimum 2 characters long and must be unique."),
 *             @OA\Property(property="salary", type="integer", minimum=2000000, maximum=10000000, example=5000000, description="Must be between 2 million and 10 million.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Employee created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="salary", type="integer", example=5000000)
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="The name field is required.")),
 *                 @OA\Property(property="salary", type="array", @OA\Items(type="string", example="The salary must be at least 2000000."))
 *             )
 *         )
 *     )
 * )
 */
class EmployeeController extends Controller
{
    private EmployeeRepositoryInterface $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Menyimpan data karyawan baru.
     *
     * @param StoreEmployeeRequest $request
     * @return JsonResponse
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $employee = $this->employeeRepository->createEmployee($data);

        return response()->json([
            'message' => 'Employee created successfully.',
            'data' => $employee,
        ], 201);
    }

    /**
     * Mengambil semua data karyawan.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $employees = $this->employeeRepository->getAllEmployees();

        return response()->json($employees, 200);
    }

    /**
     * Mengambil data karyawan berdasarkan ID.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $employee = $this->employeeRepository->getEmployeeById($id);

        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found.',
            ], 404);
        }

        return response()->json($employee, 200);
    }
}
