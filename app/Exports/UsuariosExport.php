<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Course;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsuariosExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        $dados = [];

        // USERS
        foreach (User::select('name','role', 'email', 'phone')->get() as $user) {
            $dados[] = [
                'Origem' => 'Usuário',
                'Campo1' => $user->role,
                'Campo2' => $user->name,
                'Campo3' => $user->email,
                'Campo4' => $user->phone,
            ];
        }

        $dados[] = ['', '', '', '', ''];
        $dados[] = ['', '', '', '', ''];

        // COURSES
        foreach (Course::select('title','start_date', 'slots')->get() as $course) {
            $dados[] = [
                'Origem' => 'Curso',
                'Campo1' => $course->title,
                'Campo2' => $course->start_date,
                'Campo3' => $course->slots,
                'Campo4' => '',
            ];
        }

         $dados[] = ['', '', '', '', ''];
          $dados[] = ['', '', '', '', ''];

        // EVENTS
        foreach (Event::select('title','date', 'time')->get() as $event) {
            $dados[] = [
                'Origem' => 'Evento',
                'Campo1' => $event->title,
                'Campo2' => $event->date,
                'Campo3' => $event->time,
                'Campo4' => '',
            ];
        }

        return $dados;
    }

    public function headings(): array
    {
        return ['Origem', 'Campo 1', 'Campo 2', 'Campo 3', 'Campo 4'];
    }
}
