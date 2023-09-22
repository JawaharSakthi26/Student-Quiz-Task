@extends('layouts.frontend')
@section('content')

<div class="container">
    <h1 class="text-center mb-4">{{ $title->quiz_title }} Quiz</h1>
    <div id="notification" class="alert alert-danger" style="display: none;"></div>
    <form method="post" action="{{ route('quiz.store') }}" id="quizForm">
        @csrf
        <input type="hidden" name="submission_source" id="submission_source" value="normal">
        @foreach ($title->questions as $question)
            <div class="card mb-4">
                <div class="card-body">
                    <p class="card-text">{{ $question->question }}</p>
                    <ul class="list-group">
                        @foreach ($question->answers as $answer)
                            <li class="list-group-item">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="question_{{ $question->id }}" value="{{ $answer->option }}">
                                    {{ $answer->option }}
                                </label>
                            </li>
                        @endforeach
                        <input type="hidden" name="title_id" value="{{ $title->id }}">
                    </ul>
                </div>
            </div>
        @endforeach
        <button type="button" id="submitQuiz" class="btn btn-primary">Submit Quiz</button>
    </form>
</div>

<script>
$(document).ready(function () {
    var isSubmitting = false;
    var isLeavingPage = false;

function submitQuizAsFailed() {
    if (!isSubmitting && isLeavingPage) {
        $("#notification").html("Quiz submitted as failed (browser closed).").show();

        $("#submission_source").val("browser_close");
        var formData = $("#quizForm").serialize();

        $.ajax({
            type: "POST",
            url: "{{ route('quiz.store') }}",
            data: formData,
            success: function (response) {
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
}
    window.onbeforeunload = function (event) {
        if (!isSubmitting) {
            isLeavingPage = true;
            submitQuizAsFailed();
            return "Are you sure you want to leave this page? Your quiz will be submitted as failed.";
        }
    };

    $("#submitQuiz").click(function () {
        isSubmitting = true;
        
        var totalQuestions = {{ count($title->questions) }};
        var selectedQuestions = $("input[type='radio']:checked").length;

        if (selectedQuestions === totalQuestions) {
            $("#notification").hide();
            $("#submission_source").val("normal");
            $("#quizForm").submit();
        } else {
            $("#notification").html("Please answer all questions.").show();
        }
    });
});
</script>
@endsection
