<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Course;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsuariosExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        $users = User::select('role', 'name', 'email', 'phone')->get();
        $courses = Course::select('title', 'start_date', 'slots')->get();
        $events = Event::select('title', 'date', 'time')->get();

        $maxRows = max($users->count(), $courses->count(), $events->count());

        $dados = [];

        for ($i = 0; $i < $maxRows; $i++) {
            $user = $users[$i] ?? null;
            $course = $courses[$i] ?? null;
            $event = $events[$i] ?? null;

            $dados[] = [
                // Usuário
                $user->role ?? '',
                $user->name ?? '',
                $user->email ?? '',
                $user->phone ?? '',

                '', // espaço

                // Curso
                $course->title ?? '',
                $course->start_date ?? '',
                $course->slots ?? '',

                '', // espaço

                // Evento
                $event->title ?? '',
                $event->date ?? '',
                $event->time ?? '',
            ];
        }

        return $dados;
    }

    public function headings(): array
    {
        return [
            'Usuário: Função',
            'Usuário: Nome',
            'Usuário: Email',
            'Usuário: Telefone',

            '',

            'Curso: Título',
            'Curso: Início',
            'Curso: Vagas',

            '',

            'Evento: Título',
            'Evento: Data',
            'Evento: Hora',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Cabeçalho negrito e fundo cinza claro
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 12],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'f0f0f0'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Bordas e alinhamento para todas as células com conteúdo
        $lastRow = count($this->array()) + 1; // +1 por causa do cabeçalho
        $sheet->getStyle("A1:M{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['argb' => 'CCCCCC'],
                ],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Auto tamanho das colunas
        foreach (range('A', 'M') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}
