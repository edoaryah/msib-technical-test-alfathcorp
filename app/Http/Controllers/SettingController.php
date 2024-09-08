<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Repositories\SettingRepositoryInterface;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Patch(
 *     path="/api/settings",
 *     summary="Update a setting",
 *     tags={"Settings"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="key",
 *                 type="string",
 *                 example="overtime_method",
 *                 description="Can only be filled with 'overtime_method'."
 *             ),
 *             @OA\Property(
 *                 property="value",
 *                 type="integer",
 *                 example=1,
 *                 description="Can only be filled with the ID from references table where the code starts with 'overtime_method'."
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Setting updated successfully.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Setting updated successfully."),
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(property="key", type="string", example="overtime_method"),
 *                 @OA\Property(property="value", type="integer", example=1)
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="The given data was invalid."),
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="key", type="array", @OA\Items(type="string", example="The key field is required.")),
 *                 @OA\Property(property="value", type="array", @OA\Items(type="string", example="The value field is required."))
 *             )
 *         )
 *     )
 * )
 */
class SettingController extends Controller
{
    private SettingRepositoryInterface $settingRepository;

    public function __construct(SettingRepositoryInterface $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function update(UpdateSettingRequest $request): JsonResponse
    {
        $data = $request->validated();
        $setting = $this->settingRepository->updateSetting($data['key'], $data['value']);

        return response()->json([
            'message' => 'Setting updated successfully.',
            'data' => $setting,
        ], 200);
    }
}
