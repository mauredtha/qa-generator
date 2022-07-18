<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Redirect;

class QaGeneratorsController extends Controller
{
    public function showFormGenerate()
    {
        return view('qa.create');
    }

    public function store(Request $request)
    {
        //dd($request->sourceText);
        
        if(isset($request->sourceText)){
            Storage::disk('local')->put('Asli.txt', $request->sourceText);
        }else {

            $request->validate([
            'sourceFile' => 'required|mimes:txt|max:10048',
            ]);

            if($request->file('sourceFile')){
                //dd(1);
                //$name = date('YmdHis').'_'.$request->file->getClientOriginalName();
                //$filePath = $request->file('file')->storeAs('uploads', $name, 'public');
                //$fileName = date('YmdHis').'_'.$request->file->getClientOriginalName();
                //$insert['file'] = $fileName;
                $request->file('sourceFile')->storeAs('', 'Asli.txt');
            }
        }
        

        $process = new Process(['python3', '/Users/deryan/Documents/teacherbot/storage/app/cobaqa.py']);
        $process->setTimeout(36000);
        $process->setIdleTimeout(18000);
        $process->run();

        // error handling
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output_data = $process->getOutput();
        $output_data = explode('----', $process->getOutput());

        $data = [];
        foreach ($output_data as $key => $value) {
            //print_r($value);
            
            $source = substr($value, 0, strpos($value, "QS"));
            $data[$key]['source'] = $source;
            $qs_aw = substr($value, strpos($value, "QS"), strpos($value, "AW"));
            //print_r($qs_aw);
            $qs = substr($qs_aw, 0, strpos($qs_aw, "AW"));
            $data[$key]['question'] = $qs;
            $data[$key]['answer'] = substr($qs_aw, strlen($qs));
            //$question = explode('\tQS\t', $value);
            //print_r($data);exit;
            
        }
        
        //print_r($data);exit;
        //Storage::disk('local')->put('Output.txt', $output_data);
        

        return View::make('qa.create')
               ->with('data', $data);

    }
}