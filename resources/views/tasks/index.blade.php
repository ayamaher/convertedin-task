@extends('layouts.app') <!-- Assuming you have a master layout file -->

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
                    <td>{{ $task->assignedTo->name }}</td> <!-- Assuming assignedTo is the relationship with User model -->
                    <td>{{ $task->assignedBy->name }}</td> <!-- Assuming assignedBy is the relationship with Admin model -->
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $tasks->links() }}
    </div>
@endsection
