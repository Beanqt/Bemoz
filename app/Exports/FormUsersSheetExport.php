<?php namespace App\Exports;

use App\Models\Codes;
use App\Models\UserGifts;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class FormUsersSheetExport implements FromCollection, WithTitle, WithHeadings {
    protected $type;
    protected $data;
    protected $headers;

    public function __construct($type, $data = null, $headers = []){
        $this->type = $type;
        $this->data = $data;
        $this->headers = $headers;
    }

    public function title(): string{
        return 'fillers';
    }

    public function collection(){
        return $this->data;
    }

    public function headings(): array{
        return $this->headers;
    }
}