<?php

namespace App\Http\Controllers;
use App\Models\ExamTime;
use App\Models\ExamDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExamTimeController extends Controller
{
    public function saveExamTimes(Request $request)
{
    $data = $request->json()->all();
    $timesString = str_replace(['[', ']', '"'], '', $data['times']);
    $timesArray = explode(',', $timesString);
    
    // Get the latest ExamDay ID from the 'exam_days' table
    $latestExamDayID = ExamDay::latest('id')->value('id');

    foreach ($timesArray as $time) {
        $trimmedTime = trim($time);

        if (!empty($trimmedTime)) {
            $examTime = new ExamTime([
                'exam_time' => $trimmedTime,
                'exam_day_ID' => $latestExamDayID
            ]);
            $examTime->save();
        }
    }

    return response()->json([])->header('Location', route('exam.create'));
}

    
    

}
    
    


    

    

