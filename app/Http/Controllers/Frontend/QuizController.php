<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Exam;
use App\Models\Exam_detail;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $submissionSource = $request->input('submission_source');
        if ($submissionSource === 'browser_close') {
            Exam::create([
                'user_id' => Auth::user()->id,
                'title_id' => $request->title_id,
                'status' => 'Completed',
                'result' => 'Fail',
            ]);
        }
        else{
            $userScore = 0;
            $totalQuestions = 0;

            foreach ($request->all() as $key => $value) {
                if (strpos($key, 'question_') === 0) {
                    $questionId = substr($key, strlen('question_'));
                    $correctAnswer = Answer::where('question_id', $questionId)
                        ->where('answer', 1)
                        ->first();

                    if ($correctAnswer && $value == $correctAnswer->option) {
                        $userScore++;
                        Exam_detail::create([
                            'user_id' => Auth::user()->id,
                            'question_id' => $questionId,
                            'answer' => 1, 
                        ]);
                    }else {
                        Exam_detail::create([
                            'user_id' => Auth::user()->id,
                            'question_id' => $questionId,
                        ]);
                    }
                    $totalQuestions++;
                }
            }
            $percentageScore = ($userScore / $totalQuestions) * 100;
            $isPassed = $percentageScore >= 50;
            $exam = Exam::create([
                'user_id' => Auth::user()->id,
                'title_id' => $request->title_id,
                'status' => 'Completed',
                'result' => $isPassed ? 'Pass' : 'Fail',
            ]);
            return redirect()->route('home');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::user()->id;
        $completedExam = Exam::where('user_id', $userId)
            ->where('title_id', $id)
            ->first();
        if ($completedExam && $completedExam->status == 'Completed') {
            return redirect()->route('home');
        }
        $title = Title::with('questions.answers')->find($id);
        return view('Frontend.quiz', compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
