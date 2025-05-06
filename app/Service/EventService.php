<?php

namespace App\Service;

use App\Service\FileService;
use App\Models\Event;

class EventService
{
    private $eventModel;
    private $fileService;
    public function __construct(Event $eventModel, FileService $fileService)
    {
        $this->eventModel = $eventModel;
        $this->fileService = $fileService;
    }

    public function getAllEvents()
    {
        return $this->eventModel->all();
    }

    public function getEventById($id)
    {
        return $this->eventModel->find($id);
    }

    public function createEvent($data)
    {
        $data['image'] = $this->fileService->uploadPhoto($data);

        return $this->eventModel->create($data);
    }

    public function updateEvent($id, $data)
    {
        $event = $this->getEventById($id);
        if ($event) {
            $event->update($data);
            return $event;
        }
        return null;
    }

    public function deleteEvent($id)
    {
        $event = $this->getEventById($id);
        if ($event) {
            $event->delete();
            return true;
        }
        return false;
    }

    public function getActiveEvents()
    {
        return $this->eventModel->where('active', true)->get();
    }
}
