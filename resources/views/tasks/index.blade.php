@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Task List</h1>

        <table class="table">
            <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Assigned Name</th>
                <th>Admin Name</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->assignedTo->name }}</td>
                    <td>{{ $task->assignedBy->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $tasks->links('pagination::bootstrap-4') }}
    </div>
@endsection
