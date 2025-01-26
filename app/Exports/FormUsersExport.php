<?php namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FormUsersExport implements WithMultipleSheets {
    use Exportable;

    protected $data;
    protected $headers;

    public function __construct($data, $headers){
        $this->data = $data;
        $this->headers = $headers;
    }

    public function sheets(): array {
        $sheets = [];
        $sheets[] = new FormUsersSheetExport(1, $this->data, $this->headers);
        return $sheets;
    }
}