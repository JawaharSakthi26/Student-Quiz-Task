@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    @if (isset($data))
        <h1>Edit Quiz</h1>
        <form method="POST" action="{{ route('admin.update', $data['title']->id) }}" id="quiz-form">
        @method('PUT')
    @else
        <h1>Add Quiz</h1>
        <form method="POST" action="{{route('admin.store')}}" id="quiz-form">
    @endif
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Quiz Title:</label>
            <input type="text" id="quiz_title" name="quiz_title" class="form-control" value="{{ isset($data['title']) ? $data['title']->quiz_title : '' }}">
            <span id="title-error" class="text-danger"></span>
        </div>
        <div id="quiz-container">
            <!-- Existing questions and answers will be appended here -->
        </div>
        <button type="button" id="add-questions" class="btn btn-primary mb-3">Add Questions</button>
        <button type="submit" class="btn btn-success mb-3" id="submit-btn">Submit</button>
    </form>
</div>

<script>
    @if(isset($data))
        var questionData = @json($data['questions']);
        console.log(questionData);
        $(document).ready(function() {
            questionData.forEach(function(question) {
                addquesandans(question);
            });
        });
    @endif
    
    let quesCount = 0;
    let answerIndex = 0;

    function addquesandans(questionData) {
        quesCount++;
        const quesIndex = quesCount; 
        answerIndex = 0; 
        console.log(quesIndex);
        const quesField = `
            <div class="question mb-3 p-3 border" id="question-${quesIndex}">
                <label for="question-name-${quesIndex}" class="form-label">Question:</label>
                <input type="text" id="question-name-${quesIndex}" name="questions[${quesIndex}][question]" value="${questionData ? questionData.question : ''}" class="form-control" >
                <input type="hidden" id="question-id-${quesIndex}" name="questions[${quesIndex}][id]" value="${questionData ? questionData.id : ''}" class="form-control" >
                <button type="button" class="add-answer btn btn-primary mt-2" data-quesIndex="${quesIndex}">Add Answer</button>
                <button type="button" class="remove-question btn btn-danger mt-2">Remove Question</button>
                <div class="error-message text-danger" id="question-error-${quesIndex}"></div>
                <div class="answer-container mt-2" id="answer-container-${quesIndex}"></div>
            </div>
        `;
        $('#quiz-container').append(quesField);

        $(`#question-name-${quesIndex}`).rules('add', {
            required: true,
            messages: {
                required: 'Question is required.'
            }
        });
        validateAnswer(quesIndex);

        @if (isset($data))
        if (questionData.answers && questionData.answers.length > 0) {
            questionData.answers.forEach(function(ansData) {
                addAnswer(quesIndex, ansData);
            });
        }
        @endif
    }

    answerIndex = 0; 
    function addAnswer(quesIndex, answerData) {

        console.log(quesIndex);
        console.log(answerIndex);

        const answerField = `
            <div class="answer mb-2">
                <label for="answer-${quesIndex}-name-${answerIndex}" class="form-label">Answer Text:</label>
                <input type="text" id="answer-${quesIndex}-name" name="questions[${quesIndex}][answers][answer][]" value="${answerData ? answerData.option : ''}" class="form-control" >
                <label class="form-check-label">Is Correct Answer:</label>
                <div class="form-check">
                    <input type="radio" id="radio-yes-${quesIndex}-${answerIndex}" name="questions[${quesIndex}][answers][isCorrect]" value="${answerIndex}" class="form-check-input" ${answerData && answerData.answer == '1' ? 'checked' : ''} >
                    <label class="form-check-label" for="radio-yes-${quesIndex}-${answerIndex}">Yes</label>
                </div>
                <input type="hidden" id="answer-${quesIndex}-id-${answerIndex}" name="questions[${quesIndex}][answers][answerId][]" value="${answerData ? answerData.id : ''}" class="form-control" >
                <button type="button" class="remove-answer btn btn-danger mt-2" data-quesIndex=${quesIndex} data-answerIndex=${answerIndex}>Remove Answer</button>
                <div class="error-message text-danger" id="answer-error-${quesIndex}"></div>
            </div>
        `;
        $(`#answer-container-${quesIndex}`).append(answerField);
        answerIndex++;

        $(`#answer-${quesIndex}-name`).rules('add', {
            required: true,
            messages: {
                required: 'Answer is required.'
            }
        });
        validateAnswer(quesIndex);
    }

    $('#submit-btn').click(function(){
        validateAnswer(); 
    });

    $('#add-questions').click(function() {
        addquesandans();
        validateAnswer();
    });

    $('#quiz-container').on('click', '.add-answer', function() {
        const quesIndex = $(this).closest('.question').attr('id').split('-')[1];
        addAnswer(quesIndex);
        validateAnswer(quesIndex);
    });

    $('#quiz-container').on('click', '.remove-question', function() {
        $(this).parent().remove();
    });

    $('#quiz-container').on('click', '.remove-answer', function() {
        $(this).parent().remove();
        validateAnswer();
    });

    $('#quiz-form').validate({
        rules: {
            'quiz_title': {
                required: true
            }
        },
        messages: {
            'quiz_title': {
                required: 'Title field is required.'
            }
        },

        submitHandler: function(form) {
            const questionContainers = $('.question');
            let allQuestionValid = true;

            questionContainers.each(function() {
                const quesIndex = $(this).attr('id').split('-')[1];
                const answerCount = $(`#answer-container-${quesIndex} .answer`).length;

                if (answerCount == 0) {
                    allQuestionValid = false;
                    $(`#question-error-${quesIndex}`).html('At least one answer is required for this question.').show();
                } else {
                    $(`#question-error-${quesIndex}`).html('').hide();
                }
            });
            if (allQuestionValid) {
                form.submit();
            }
        }
    });

    function validateAnswer(quesIndex) {
        if (quesIndex) {
            const answerCount = $(`#answer-container-${quesIndex} .answer`).length;
            if (answerCount == 0) {
                $(`#question-error-${quesIndex}`).html('At least one answer is required for this question.').show();
            } else {
                $(`#question-error-${quesIndex}`).html('').hide();
            }
        } else {
            const questionContainers = $('.question');
            if (questionContainers.length === 0) {
                $('#quiz-container').append('<div class="text-danger error">Fill atleast one question.</div>');
            } else {
                $('#quiz-container .error').remove();
            }
        }
    }
</script>
@endsection