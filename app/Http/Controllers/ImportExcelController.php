<?php

namespace App\Http\Controllers;

use App\Imports\ImportWhatsAppNumDU;
use App\Imports\MostImportImportNum;
use App\Models\TestNumberEmirti;
use Illuminate\Http\Request;
// use Excel;
use Maatwebsite\Excel\Facades\Excel;


class ImportExcelController extends Controller
{
    //
    public function ImportExcel()
    {
        // return "b";
        return view('dashboard.import');
    }
    //
    public function import(Request $request){
        // return
        // return $request;
        $this->validate($request, [
            'select_file'  => 'required|mimes:xls,xlsx'
        ]);

        // $path = $request->file('select_file')->getRealPath();
        $path1 = $request->file('select_file')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        // $path = storage_path('app') . '/' . $path1;
        // $data = \Excel::import(new UsersImport, $path);

        // $data = Excel::Import(new $path);
        // Excel::import(new NumberImport, $path);
        Excel::import(new ImportWhatsAppNumDU, $path);
        return back()->with('success', 'Number Data Imported successfullys.');
    }
    //
    public function MostImport()
    {
        // return "b";
        return view('dashboard.MostImport');
    }
    //
    public function MostImportImport(Request $request){
        // return
        ini_set('max_execution_time', '3000'); //300 seconds = 5 minutes

        // return $request;
        $this->validate($request, [
            'select_file.*'  => 'required|mimes:xls,xlsx'
        ]);

        foreach ($request->file('select_file') as $f) {
            // return $f;
        // $path = $request->file('select_file')->getRealPath();
        // $path1 = $request->file('select_file')->store('temp');
        $path1 = $f->store('temp');
        $path = storage_path('app') . '/' . $path1;
        // $path = storage_path('app') . '/' . $path1;
        // $data = \Excel::import(new UsersImport, $path);

        // $data = Excel::Import(new $path);
        // Excel::import(new NumberImport, $path);
        Excel::import(new MostImportImportNum, $path);
        }

        return back()->with('success', 'Number Data Imported successfullys.');
    }
    // /
    public function Mygame(Request $request){


        // $number = 971589999999;
        // $zp = substr($number,5);

        ini_set('max_execution_time', '300000'); //300 seconds = 5 minutes

         $duplicates = \DB::table('test_number_emirtis') // replace table by the table name where you want to search for duplicated values
            ->select('id', 'number') // name is the column name with duplicated values
            ->whereIn('number', function ($q) {
                $q->select('number')
                ->from('test_number_emirtis')
                    ->groupBy('number')
                    ->havingRaw('COUNT(*) > 1');
            })
            ->orderBy('number')
            ->orderBy('id') // keep smaller id (older), to keep biggest id (younger) replace with this ->orderBy('id', 'desc')
            ->limit(1000)
            ->get();
            $value = "";

            foreach ($duplicates as $duplicate) {
            if ($duplicate->number === $value) {
                \DB::table('test_number_emirtis')->where('id', $duplicate->id)->delete(); // comment out this line the first time to check what will be deleted and keeped
                echo "$duplicate->number with id $duplicate->id deleted! \n";
            } else
            echo "$duplicate->number with id $duplicate->id keeped \n";
            $value = $duplicate->number;
        }
        return "Mission Complete";

        //

        //
        // ini_set('max_execution_time', '-1'); //300 seconds = 5 minutes
        //
        $numberstart = TestNumberEmirti::orderBy('id', 'desc')->first();
        if (!$numberstart) {
            $numberstart = 1000000;
        } else {
             $numberstart = $numberstart->number;
        }
        if ($numberstart === 9999999 || $numberstart > 9999999) {
            return "Game Over";
        }
        // $end = $numberstart + 5;
        $end = $numberstart + 1000000;
        // for ($v = $numberstart; $v <= '971583999999'; $v++) {
        for ($v = $numberstart; $v <= $end; $v++) {
            // for($i='971581000000';$i<= '971581001000';$i++){
                // return $v;
            //     // echo $i . '</br>';
            //     // $d=
            //         if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
            //             $d = WhatsAppScan::create([
            //                 'wapnumber' => $i,
            //             ]);
            //         }
            // }
            // $regex = “\\b([a-zA-Z0-9])\\1\\1+\\b”;
            // for($i='971581000000';$i<= '971581002000';$i++){
            // \Log::info($v)
            // return $v;
            if (preg_match('/(.)\\1{6}/', $v)) {
                $data[] = [
                    'number' => $v,
                    'count_digit' => 7,
                ];
            } elseif (preg_match('/(.)\\1{5}/', $v)) {
                // echo '###' . $i . '<br> => 5 Times Number';
                $data[] = [
                    'number' => $v,
                    'count_digit' => 6,
                ];
            } elseif (preg_match('/(.)\\1{4}/', $v)) {
                // echo '###' . $i . '<br> => 5 Times Number';
                $data[] = [
                    'number' => $v,
                    'count_digit' => 5,
                ];
            } else if (preg_match('/(.)\\1{3}/', $v)) {
                // echo '###' . $i . '<br> => 4 Times Number';
                $data[] = [
                    'number' => $v,
                    'count_digit' => 4,
                ];
            } else if (preg_match('/(.)\\1{2}/', $v)) {
                // echo '###' . $i . '<br> => 3 Times Number';
                $data[] = [
                    'number' => $v,
                    'count_digit' => 3,
                ];
            } else if (preg_match('/(.)\\1{1}/', $v)) {
                // echo '###' . $i . '<br> => 2 Times Number';
                $data[] = [
                    'number' => $v,
                    'count_digit' => 2,
                ];
            }
            // else if (preg_match('/(.)\\1{1}/', $i)) {
            //     // echo '###' . $i . '<br> => 2 Times Number';
            //     if (!WhatsAppScan::where('wapnumber', '=', $i)->exists()) {
            //         $d = WhatsAppScan::create([
            //             'wapnumber' => $i,
            //         ]);
            //     }
            // }
            else {
                // echo $i . ' => <br>' . '=> No 3 Times';
                $data[] = [
                    'number' => $v,
                    'count_digit' => 'random',
                ];
            }
        }
        // return "soo";
        $chunks = array_chunk($data, 5000);
        foreach ($chunks as $chunk) {
            TestNumberEmirti::query()->insert($chunk);
        }
    }
}
