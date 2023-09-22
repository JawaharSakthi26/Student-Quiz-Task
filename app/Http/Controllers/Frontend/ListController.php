<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Title;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function index()
    {
        $titles = Title::all();
        $user = Auth::user();

        $userExams = Exam::where('user_id', $user->id)->get();
        $titleData = [];

        foreach ($titles as $title) {
            $titleId = $title->id;
            $userExam = $userExams->where('title_id', $titleId)->first();
    
            if ($userExam) {
                $status = $userExam->status;
                $result = $userExam->result;
            } else {
                $status = 'NOT YET STARTED';
                $result = 'NIL';
            }
    
            $titleData[] = [
                'titleId' => $titleId, 
                'title' => $title->quiz_title,
                'status' => $status,
                'result' => $result,
            ];
        }
        return view('Frontend.list', compact('titleData'));
    }
}