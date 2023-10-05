@extends('layouts.app')

@section('content')
    <div class="container">
        <?php $response = session('response') ?>
        @if($response)
            @if($response['type'] == "success")
                <div class="alert alert-success" role="alert">
                    {{ $response['message'] }}
                </div>
            @elseif($response['type'] == "error")
                <div class="alert alert-danger" role="alert">
                    {{ $response['message'] }}
                </div>
            @endif
        @endif
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-warning" onclick="window.location='{{ route("task.create") }}'">Create New Task</button>
            <button type="button" class="btn btn-info" onclick="window.location='{{ route("statistics.list") }}'">Statistics</button>
        </div>
        <h2>Task List</h2>
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
