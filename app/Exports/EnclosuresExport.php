<?php

namespace App\Exports;

use App\Models\Enclosure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EnclosuresExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Enclosure::with(['zone.district'])
            ->select('id', 'name', 'zone_id')
            ->get()
            ->map(function ($enclosure) {
                return [
                    'zone_name' => $enclosure->zone->name,
                    'enclosure_name' => $enclosure->name,
                ];
            });
    }

    // Define los encabezados del archivo Excel
    public function headings(): array
    {
        return [
            'Zona',
            'Recinto',
        ];
    }

    // Define los estilos para los encabezados
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [ // Se refiere a la fila 1 (encabezados)
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'], // Color de fuente (blanco)
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF0070C0'], // Color de fondo (azul)
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN, // Tipo de borde (delgado)
                        'color' => ['argb' => 'FFFFFFFF'], // Color del borde (blanco)
                    ],
                ],
            ],
        ];
    }
}
