<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ArrayExport implements FromArray, WithTitle, WithHeadings, ShouldAutoSize
{
    protected $outlets;
    protected $title;

    public function __construct(array $outlets,$title='')
    {
        $this->outlets = $outlets;
        $this->title = $title;
    }

    public function array(): array
    {
    	return $this->outlets;
    }

    public function headings(): array
    {
        return array_keys($this->outlets[0]??[]);
    	// return array_map(function($x){return ucwords(str_replace('_', ' ', $x));}, array_keys($this->outlets[0]??[]));
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }
}