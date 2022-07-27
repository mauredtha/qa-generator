<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Generator;
use Illuminate\Http\Request;
use App\Http\Requests\StoreGeneratorRequest;

use Illuminate\Support\Facades\Storage;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class QaGensController extends Controller
{
    
    public function index()
    {
        $generators = Generator::all();
        return response()->json([
            'generators' => $generators
        ]);
    }

    public function show($id)
    {
        $generator = Generator::find($id);
        if (is_null($generator)) {
        return $this->sendError('Question & Answer not found.');
        }
        return response()->json([
        "success" => true,
        "message" => "Question & Answer retrieved successfully.",
        "data" => $generator
        ]);
    }

    public function showDataByCourseId($id)
    {
        $generator = Generator::where('course_id', $id)->get();
        
        if (is_null($generator)) {
        return $this->sendError('Question & Answer not found.');
        }
        return response()->json([
        "success" => true,
        "message" => "Question & Answer retrieved successfully.",
        "data" => $generator
        ]);
    }

    // public function saveDataGenerate(StoreGeneratorRequest $request)
    public function saveDataGenerate(Request $request)
    {
        //$course = Course::create($request->all());
        if($request->method()){
            if(isset($request->source_text)){
                //print_r(1);exit;
                Storage::disk('local')->put('Asli.txt', $request->source_text);
            }else {
                $request->validate([
                'source_file' => 'required|mimes:txt|max:10048',
                ]);

                if($request->file('source_file')){
                    $request->file('source_file')->storeAs('', 'Asli.txt');
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
                $data[$key]['questions'] = $qs;
                $data[$key]['answer'] = substr($qs_aw, strlen($qs));
                $data[$key]['course_id'] = $request->course_id;
                //$question = explode('\tQS\t', $value);
                //print_r($data);exit;

                $generator = new Generator;
                $generator->course_id = $request->course_id;
                $generator->source = $source;
                $generator->questions = $qs;
                $generator->answer = substr($qs_aw, strlen($qs));
                
                $generator->save();
            }

            return response()->json([
                'message' => "Q&A saved successfully!",
                'data' => $data
            ], 200);

        }
        
    }
    
    
    public function destroy(Generator $generator)
    {
        $generator->delete();

        return response()->json([
            'message' => "Q&A deleted successfully!",
        ], 200);
    }
}
