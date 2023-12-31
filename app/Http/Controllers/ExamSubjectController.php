<?php

namespace App\Http\Controllers;
use App\Models\ExamSubject;
use App\Models\ExamTime;
use App\Models\ExamDay;
use Illuminate\Http\Request;


class ExamSubjectController extends Controller
{
    function saveExamSubjects(Request $request) {
        $subjects = $request->subjects;
    
        
        $explodedSubjects = [];
    
        foreach ($subjects as $subjectData) {
            if (is_array($subjectData)) {
                
                $explodedSubjectArray = [];
                foreach ($subjectData as $subjectString) {
                    if (is_string($subjectString)) {
                        $explodedSubjectArray = array_merge($explodedSubjectArray, explode(',', $subjectString));
                    }
                }
                $explodedSubjects[] = $explodedSubjectArray;
            } else {
                dd('error in ExamSubjectController', $subjectData);
            }
        }
        // $latestExamTime = ExamTime::latest()->first();
        $latestExamPeriodID = ExamDay::latest('id')->value('exam_period_ID');
        $examdayID = ExamDay::latest('id')->value('id');
        $examTimes = ExamTime::latest()->get();
        for ($i = 0; $i < count($explodedSubjects); $i++) {
            if (isset($examTimes[$i])) {
                $subjectNameArray = $explodedSubjects[$i];
                $examTime = $examTimes[$i];
        
                foreach ($subjectNameArray as $subjectName) {
                    $examSubject = new ExamSubject(['subject_name' => $subjectName]);
                    $examSubject->exam_day_id = $examdayID;
                    $examSubject->exam_period_id = $latestExamPeriodID;
                    $examTime->examSub()->save($examSubject);
                }
            }
        }
        return response()->json(['message' => 'Successful'])->header('Location', route('exam.create'));
    }

    public function index()
    {
    
        $examSubjects = ExamSubject::all();
        
        return view('exams.index', compact('examSubjects'));
    }
}
