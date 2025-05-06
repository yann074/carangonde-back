<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Service\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Service\EventService;

class EventController extends Controller
{
    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }
    public function index()
    {
        $events = Cache::remember('events:all', 1, function () {
            return $this->eventService->getAllEvents();
        });

        return ApiResponse::success($events);
    }

    public function store(Request $request)
    {

        $user = $request->user();

        $data = $request->only(['title', 'description', 'location', 'date', 'time', 'image', 'active']);
        $data['user_id'] = $user->id;

        $event = $this->eventService->createEvent($data);

        Cache::forget('events:all');

        return ApiResponse::created($event);
    }

    public function show(Event $event)
    {
        $event = Cache::remember('events:show:' . $event->id, 10800, function () use ($event) {
            return $this->eventService->getEventById($event->id);
        });

        if (!$event) {
            return ApiResponse::notFound();
        }

        return ApiResponse::success($event);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->only(['title', 'description', 'location', 'date', 'time', 'image', 'active']);

        $event = $this->eventService->updateEvent($event->id, $data);

        if (!$event) {
            return ApiResponse::notFound();
        }

        Cache::forget('events:all');
        Cache::forget('events:show:' . $event->id);

        return ApiResponse::success($event);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $deleted = $this->eventService->deleteEvent($event->id);

        if (!$deleted) {
            return ApiResponse::notFound();
        }

        Cache::forget('events:all');
        Cache::forget('events:show:' . $event->id);

        return ApiResponse::success(['message' => 'Event deleted successfully']);
    }
}
