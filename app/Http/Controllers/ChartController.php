<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ChartController extends Controller
{
    public function index(){
       
        $modules = DB::table('modules')->select('ModuleId', 'ModuleName')->get();
        $classess = DB::table('enrolls')->select(DB::raw('ClassId as ClassId') ,DB::raw('AVG(Passed) AS Avg'))           
                                    ->groupBy("ClassId")
                                    ->get();
        $array2[] = ['ClassId', 'Avg'];
        foreach($classess as $key => $value){
            $array2[++$key] = [$value ->ClassId, $value->Avg];
        }
        return view('chart', compact('modules', 'array2'));
    }

    public function chart(Request $request){
        if($request->ajax()){
            $moduleName = $request->get('module');
            $moduleid = DB::table('modules')->where('ModuleName', $moduleName)->select('ModuleId')->first();
            $classes = DB::table('enrolls')->join('classes', 'enrolls.ClassId', '=', 'classes.ClassId')
                                            ->where('classes.ModuleId', $moduleid->ModuleId) 
                                            ->where('enrolls.Passed', 1)
                                            ->select(DB::raw('classes.ClassId as ClassId') ,DB::raw('count(enrolls.Passed) AS Avg')) 
                                            ->groupBy("classes.ClassId", "enrolls.ClassId")
                                            ->get();
            $classess = DB::table('enrolls')->select(DB::raw('count(*) AS Avg')) 
                                        ->groupBy("ClassId")
                                        ->get();
        
            $array[] = ['ClassId', 'Avg'];
            foreach($classes as $key => $value){
                $avg = ($value->Avg / $classess[0]->Avg * 1.0)* 100;
                $array[++$key] = [$value ->ClassId, $avg];
            }

            return json_encode($array);
        }
    }

    public function average_exam_grades(Request $request){
        if($request->ajax()){
            $moduleName = $request->get('module');
            $moduleid = DB::table('modules')->where('ModuleName', $moduleName)->select('ModuleId')->first();
            $classes = DB::table('enrolls')->join('classes', 'enrolls.ClassId', '=', 'classes.ClassId')  
                                            ->select(DB::raw('classes.ClassId as ClassId') ,DB::raw('SUM(enrolls.ExamGrade) AS Avg'))   
                                            ->where('classes.ModuleId', $moduleid->ModuleId)          
                                            ->groupBy("classes.ClassId", "enrolls.ClassId")
                                            ->get();
            $classess = DB::table('enrolls')->select(DB::raw('count(*) AS Avg')) 
                                        ->groupBy("ClassId")
                                        ->get();

        
            $array[] = ['ClassId', 'Avg'];
            foreach($classes as $key => $value){
                $avg = ($value->Avg / $classess[0]->Avg * 1.0);
                $array[++$key] = [$value ->ClassId, $avg];
            }

            // $classess = DB::table('enrolls')->select(DB::raw('ClassId as ClassId') ,DB::raw('AVG(Passed) AS Avg'))           
            //                         ->groupBy("ClassId")
            //                         ->get();
            // $array2[] = ['ClassId', 'Avg'];
            // foreach($classess as $key => $value){
            //     $array2[++$key] = [$value ->ClassId, $value->Avg];
            // }

            return json_encode($array);
        }
    }
    
    public function students_of_modules(Request $request){
        if($request->ajax()){
            $moduleName = $request->get('module');
            $moduleid = DB::table('modules')->where('ModuleName', $moduleName)->select('ModuleId')->first();
            $classes = DB::table('enrolls')->join('classes', 'enrolls.ClassId', '=', 'classes.ClassId')  
                                            ->select(DB::raw('classes.ClassId as ClassId') ,DB::raw('count(enrolls.ExamGrade) AS Avg'))   
                                            ->where('classes.ModuleId', $moduleid->ModuleId)          
                                            ->groupBy("classes.ClassId", "enrolls.ClassId")
                                            ->get();
            $classess = DB::table('enrolls')->select(DB::raw('count(*) AS Avg')) 
                                        ->groupBy("ClassId")
                                        ->get();
        
            $array[] = ['ClassId', 'Avg'];
            foreach($classes as $key => $value){
                $avg = ($value->Avg / $classess[0]->Avg * 1.0);
                $array[++$key] = [$value ->ClassId, $avg];
            }

            // $classess = DB::table('enrolls')->select(DB::raw('ClassId as ClassId') ,DB::raw('AVG(Passed) AS Avg'))           
            //                         ->groupBy("ClassId")
            //                         ->get();
            // $array2[] = ['ClassId', 'Avg'];
            // foreach($classess as $key => $value){
            //     $array2[++$key] = [$value ->ClassId, $value->Avg];
            // }

            return json_encode($array);
        }
    }
}
