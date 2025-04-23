<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Exception;

class EventController extends Controller
{
    protected $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/events",
     *     summary="List all events",
     *     tags={"Events"},
     *     @OA\Parameter(
     *         name="country",
     *         in="query",
     *         description="Filter by country",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of events",
     *         @OA\JsonContent(),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Internal Server Error")
     *         ),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        try {
            $filters = request()->only(['country']);
            $events = $this->eventRepository->all($filters);
            return response()->json($events, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/events",
     *     summary="Create a new event",
     *     tags={"Events"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="start_time", type="string", format="date-time"),
     *             @OA\Property(property="end_time", type="string", format="date-time"),
     *             @OA\Property(property="capacity", type="integer"),
     *             @OA\Property(property="location", type="string"),
     *             @OA\Property(property="country", type="string"),
     *             @OA\Property(property="state", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Event created",
     *         @OA\JsonContent(),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Validation error")
     *         ),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     )
     * )
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        try {
            $event = $this->eventRepository->create($request->validated());
            return response()->json($event, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/events/{id}",
     *     summary="Get event details",
     *     tags={"Events"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Event details",
     *         @OA\JsonContent(),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Event not found")
     *         ),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        try {
            $event = $this->eventRepository->find($id);
            return response()->json($event);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/events/{id}",
     *     summary="Update an event",
     *     tags={"Events"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="start_time", type="string", format="date-time"),
     *             @OA\Property(property="end_time", type="string", format="date-time"),
     *             @OA\Property(property="capacity", type="integer"),
     *             @OA\Property(property="location", type="string"),
     *             @OA\Property(property="country", type="string"),
     *             @OA\Property(property="state", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event updated",
     *         @OA\JsonContent(),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Event not found")
     *         ),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     )
     * )
     */
    public function update(UpdateEventRequest $request, int $id): JsonResponse
    {
        try {
            $event = $this->eventRepository->update($id, $request->validated());
            return response()->json($event);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/events/{id}",
     *     summary="Delete an event",
     *     tags={"Events"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=204,
     *         description="Event deleted",
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found",
     *         @OA\JsonContent(@OA\Property(property="error", type="string", example="Event not found")),
     *         @OA\Header(header="Content-Type", @OA\Schema(type="string", example="application/json")),
     *         @OA\Header(header="Accept", @OA\Schema(type="string", example="application/json"))
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->eventRepository->delete($id);
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}