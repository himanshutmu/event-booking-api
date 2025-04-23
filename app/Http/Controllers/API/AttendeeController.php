<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendeeRequest;
use App\Repositories\Contracts\AttendeeRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Exception;

class AttendeeController extends Controller
{
    protected $attendeeRepository;

    public function __construct(AttendeeRepositoryInterface $attendeeRepository)
    {
        $this->attendeeRepository = $attendeeRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/attendees",
     *     summary="Register a new attendee",
     *     tags={"Attendees"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Attendee registered",
     *         @OA\JsonContent(),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation error")
     *         ),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     )
     * )
     */
    public function store(StoreAttendeeRequest $request): JsonResponse
    {
        try {
            $attendee = $this->attendeeRepository->create($request->validated());
            return response()->json($attendee, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
