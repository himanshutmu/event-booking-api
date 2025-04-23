<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Repositories\Contracts\BookingRepositoryInterface;
use App\Repositories\Contracts\AttendeeRepositoryInterface;
use App\Repositories\Contracts\EventRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingController extends Controller
{
    protected $bookingRepository;
    protected $attendeeRepository;
    protected $eventRepository;

    public function __construct(
        BookingRepositoryInterface $bookingRepository,
        AttendeeRepositoryInterface $attendeeRepository,
        EventRepositoryInterface $eventRepository
    ) {
        $this->bookingRepository = $bookingRepository;
        $this->attendeeRepository = $attendeeRepository;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @OA\Post(
     *     path="/api/bookings",
     *     summary="Book an event",
     *     tags={"Bookings"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="event_id", type="integer"),
     *             @OA\Property(property="email", type="string", format="email")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Booking created",
     *         @OA\Header(header="Location", description="Location of the new booking", @OA\Schema(type="string", format="uri")),
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="event_id", type="integer", example=1),
     *             @OA\Property(property="attendee_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,         
     *         description="Event not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Event not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Duplicate booking",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Duplicate booking")
     *         )
     *     )
     * )
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $attendee = $this->attendeeRepository->findByEmail($data['email']);
            $event = $this->eventRepository->find($data['event_id']);

            if ($this->bookingRepository->exists($data['event_id'], $attendee->id)) {
                return response()->json(['error' => 'Duplicate booking'], 422);
            }

            if ($this->bookingRepository->countByEvent($data['event_id']) >= $event->capacity) {
                return response()->json(['error' => 'Event is fully booked'], 422);
            }

            $booking = DB::transaction(function () use ($data, $attendee) {
                return $this->bookingRepository->create([
                    'event_id' => $data['event_id'],
                    'attendee_id' => $attendee->id,
                ]);
            });

            return response()->json($booking, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}