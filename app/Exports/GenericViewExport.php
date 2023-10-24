<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class GenericViewExport implements FromView
{
    private Collection  $data;
    private String $view;

    public function __construct($data, $view)
    {
        $this->data = $data;
        $this->view = $view;
    }

    public function view(): View
    {
        return view("exports.excel.$this->view", ['data'=>$this->data]);
    }
}
