<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Lib\MyHelper;

class ProductExport implements FromArray,WithTitle, ShouldAutoSize, WithEvents
{
	protected $data;
    protected $brand;
    protected $tab_title;

    public function __construct(array $data,$brand='',$tab_title = 'List Products')
    {
        $this->data = $data;
        $this->brand = $brand;
        $this->tab_title = $tab_title;
    }

    /**
    * @return Array
    */
    public function array(): array
    {
    	$array = [
            ['Brand Code',$this->brand],
            array_keys($this->data[0]??[])
        ];
        return $array+$this->data;
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return $this->tab_title;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $last = count($this->data);
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ]
                    ],
                ];
                $styleHead = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],
                ];
                $x_coor = MyHelper::getNameFromNumber(count($this->data[0]??[]));
                $event->sheet->getStyle('A2:'.$x_coor.$last)->applyFromArray($styleArray);
                $headRange = 'A2:'.$x_coor.'2';
                $event->sheet->getStyle($headRange)->applyFromArray($styleHead);
            },
        ];
    }
}