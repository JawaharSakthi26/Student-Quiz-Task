<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Title;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titles = Title::with('questions')->get();
        return view('Admin.list', compact('titles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $title = Title::create([
            'quiz_title' => $request->quiz_title,
        ]);
        $questionsData = $request->questions;
        foreach ($questionsData as $questionData) {
            $question = $title->questions()->create([
                'title_id' => $title->id, 
                'question' => $questionData['question'],
            ]);

            if (isset($questionData['answers'])) {
                foreach ($questionData['answers']['answer'] as $k => $answer) {
                   if($questionData['answers']['isCorrect'] == $k){
                    $answerValue = '1';
                   }else{
                    $answerValue = '0';
                   }
                    $question->answers()->create([
                        'question_id' => $question->id,
                        'option' => $answer,
                        'answer' => $answerValue,
                    ]);
                }
            }
        }
        return redirect()->route('admin.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = Title::with('questions.answers')->findOrFail($id);
        $data = [
            'title' => $title,
            'questions' => $title->questions,
        ];
        return view('Admin.create',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request);
        $title = Title::findorFail($id);
        $title->update([
            'quiz_title' => $request->quiz_title,
        ]);

        $updatedQuestionIds = [];
        $updatedAnswerIds = [];

        foreach ($request->input('questions') as $questionData) {
            if (isset($questionData['id'])) {
                $question = Question::findOrFail($questionData['id']);
                $question->update([
                    'question' => $questionData['question'],
                ]);
            $updatedQuestionIds[]= $question->id;
            } else {
                $question = Question::create([
                    'title_id' => $title->id,
                    'question' => $questionData['question'],
                ]);
            $updatedQuestionIds[]= $question->id;
            }
            if (isset($questionData['answers'])) {
                foreach ($questionData['answers']['answer'] as $key => $answerData) {
                    $answerValue = $answerData;
                    $isSelected = '0';
                    if ($questionData['answers']['isCorrect'] == $key) {
                        $isSelected = '1'; 
                    }
                    $answerData = [
                        'question_id' => $question->id,
                        'option' => $answerValue,
                        'answer' => $isSelected,
                    ];

                    if (isset($questionData['answers']['answerId'][$key])) {
                        $answerData['id'] = $questionData['answers']['answerId'][$key];
                        $answer = Answer::findOrFail($answerData['id']);
                        $answer->update($answerData);
                        $updatedAnswerIds[] = $answer->id;
                    } else {
                        $answer = Answer::create($answerData);
                        $updatedAnswerIds[] = $answer->id;
                    }
                }
            }
        }
        $title->questions()->whereNotIn('id', $updatedQuestionIds)->delete();

        $title->questions()->each(function ($question) use ($updatedAnswerIds) {
            $question->answers()->whereNotIn('id', $updatedAnswerIds)->delete();
        });
        return redirect()->route('admin.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $title = Title::find($id);
        if ($title) {
            $title->delete();
        }
        return redirect()->route('admin.index');
    }
}
