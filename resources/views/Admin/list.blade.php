@extends('layouts.admin')
@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Quiz Title List</h1>
        <div class="d-flex">
            <a href="{{route('admin.create')}}" class="btn btn-primary me-2">Add New Quiz</a>
        </div>
    </div>
    <table class="table table-dark table-sm">
        <thead>
            <tr>
                <th>Quiz Title</th>
                <th>Number of Questions</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($titles as $title)
                <tr>
                    <td>{{ $title->quiz_title }}</td>
                    <td>{{ $title->questions->count() }}</td>
                    <td>
                        <a href="{{ route('admin.edit', $title->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{route('admin.destroy',$title->id)}}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection