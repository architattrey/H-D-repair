<?php

namespace App\Imports;

use App\models\ServiceProvider;
use Maatwebsite\Excel\Concerns\ToModel;


class InvoiceImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ServiceProvider([
            'cat'=>(isset($row[0]) && !empty($row[0]))? ltrim($row[0]," "):" ",
            'sub_cat' =>(isset($row[1]) && !empty($row[1]))? ltrim($row[1]," "):" ",
            'name'=>(isset($row[2]) && !empty($row[2]))? ltrim($row[2]," "):" ",
            'phone'=>(isset($row[3]) && !empty($row[3]))? ltrim($row[3]," "):" ",
            'address'=>(isset($row[4]) && !empty($row[4]))? ltrim($row[4]," "):" ",
            'district'=>(isset($row[5]) && !empty($row[5]))? ltrim($row[5]," "):" ",
            'state'=>(isset($row[6]) && !empty($row[6]))? ltrim($row[6]," "):" ",
            'pin_code'=>(isset($row[7]) && !empty($row[7]))? ltrim($row[7]," "):" ",
            'price'=>(isset($row[8]) && !empty($row[8]))? ltrim($row[8]," "):" ",
            'raitings'=>"0",
            'status'=>NULL,
            'delete_status'=>'1',
            'created_at'=>date('Y-m-d'),   
        ]);
    }
}
