<?php

namespace App\Imports;

use App\Models\number_matcher;
use App\Models\TestNumberEmirti;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
// use romanzipp\QueueMonitor\Traits\IsMonitored; // <---




class MostImportImportNum implements ToCollection
    ,
    WithStartRow
    ,WithChunkReading,
    ShouldQueue


{
    // use IsMonitored;
    // use IsMonitoredlando;// <---
    /**
    * @param Collection $collection
    */
    public function startRow(): int
    {
        return 2;
    }
    public function collection(Collection $collection)
    {
        //

        // dd($collection);
        ini_set('max_execution_time', '3000'); //300 seconds = 5 minutes

        foreach ($collection as $row) {
            // dd($row);
            // if($row['9'] == 'number')
            if(is_numeric($row['4']) && strlen($row['4']) > 7 || $row['4'] == 'number'){
                // dd($row);
                if ($row['6'] == 'TRUE' || $row['6'] == true) {
                    $prepaid = 'prepaid';
                } else {
                    $prepaid = 'postpaid';
                }
                if ($row['5'] == '' || $row['5'] == null) {
                    $customerType = 'blank';
                } else {
                    $customerType = $row[0];
                }
                if ($row['10'] == '' || $row['10'] == null) {
                    $plan = 'blank';
                } else {
                    $plan = $row[10];
                }
                if (!number_matcher::where('number', '=', $row[4])->exists()) {
                    // $num = number_matcher::where('number',$`)
                    // if($numbe)
                    number_matcher::create(
                        [
                            'number' => $row['4'],
                            // 'customerType' => $row['0'],
                            'plan' => $plan,
                            // 'number' => $row['4'],
                            'post_or_pre' => $prepaid,
                            'customerType' => $customerType,
                        ]
                    );
                    $zp = substr($row[4], 5);
                    // dd($zp);
                    $pp = TestNumberEmirti::where('number', $zp)->first();
                    if (!$pp) {
                        dd($row[4] . "ZZ");
                    }
                    $pp->five_five = 'found';
                    $pp->save();
                }
            }
            else if(is_numeric($row['9']) && strlen($row['9']) > 7 || $row['9'] == 'number'){
                // dd($row);
                if ($row['4'] == 'TRUE' || $row['4'] == true) {
                    $prepaid = 'prepaid';
                } else {
                    $prepaid = 'postpaid';
                }
                if ($row['1'] == '' || $row['1'] == null) {
                    $customerType = 'blank';
                } else {
                    $customerType = $row[0];
                }
                if ($row['7'] == '' || $row['7'] == null) {
                    $plan = 'blank';
                } else {
                    $plan = $row[6];
                }
                if (!number_matcher::where('number', '=', $row[9])->exists()) {
                    // $num = number_matcher::where('number',$`)
                    // if($numbe)
                    number_matcher::create(
                        [
                            'number' => $row['9'],
                            // 'customerType' => $row['0'],
                            'plan' => $plan,
                            'number' => $row['9'],
                            'post_or_pre' => $prepaid,
                            'customerType' => $customerType,
                        ]
                    );
                    $zp = substr($row[9], 5);
                    // dd($zp);
                    $pp = TestNumberEmirti::where('number', $zp)->first();
                    if (!$pp) {
                        dd($row[9] . "ZZ");
                    }
                    $pp->five_five = 'found';
                    $pp->save();
                }
            }
            else{
                // dd($row[7]);


                if($row['2'] == 'TRUE' || $row['2'] == true) {
                    $prepaid = 'prepaid';
                } else {
                    $prepaid = 'postpaid';
                }
                if($row['1'] == '' || $row['1'] == null) {
                    $customerType = 'blank';
                } else {
                    $customerType = $row[0];
                }
                if($row['6'] == '' || $row['6'] == null) {
                    $plan = 'blank';
                } else {
                    $plan = $row[6];
                }
                if (!number_matcher::where('number', '=', $row[7])->exists()) {
                    // $num = number_matcher::where('number',$`)
                    // if($numbe)
                    number_matcher::create(
                        [
                            'number' => $row['7'],
                            // 'customerType' => $row['0'],
                            'plan' => $plan,
                            'number' => $row['7'],
                            'post_or_pre' => $prepaid,
                            'customerType' => $customerType,
                        ]
                    );
                    $zp = substr($row[7], 5);
                    $pp = TestNumberEmirti::where('number', $zp)->first();
                    if(!$pp){
                        dd($row[7] . "ppp");
                    }
                    // dd($pp);
                    $pp->five_five = 'found';
                    $pp->save();
                }

            }

        }
    }
    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
