@extends('layouts.frontend')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Quiz') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <!-- Your content goes here -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Result</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($titleData as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data['title'] }}</td>
                                    <td>
                                        @php
                                            $labelClass = $data['status'] == 'Completed' ? 'badge bg-success' : 'badge bg-danger';
                                        @endphp
                                        <div class="{{ $labelClass }}">{{ $data['status'] }}</div>
                                    </td>
                                    <td>
                                        @php
                                            $labelClass = $data['result'] === 'Pass' ? 'badge bg-success' : 'badge bg-danger';
                                        @endphp
                                        <div class="{{ $labelClass }}">{{ $data['result'] }}</div>
                                    </td>
                                    <td>
                                        @if ($data['status'] != 'Completed')
                                            <a href="{{ route('quiz.show', $data['titleId']) }}" class="btn btn-warning">Start Quiz</a> 
                                            @else
                                            <button class="btn btn-secondary" disabled>Start Quiz</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection