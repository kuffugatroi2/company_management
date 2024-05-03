<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelExports implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Task::all();
    }

    public function map($row): array
    {
        return [
            $row->project->name,
            $row->description,
            $row->start_time,
            $row->end_time,
            $row->priority,
            $row->status,
            $row->person->full_name,
        ];
    }

    public function headings(): array
    {
        return [
            'Project',
            'Description',
            'Start Time',
            'End Time',
            'Priority',
            'Status',
            'Person',
        ];
    }
}
