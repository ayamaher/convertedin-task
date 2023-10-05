@extends('layouts.app') <!-- Assuming you have a master layout file -->

@section('content')
    <div class="container">
        <h2>Create Task</h2>

        <form action="{{ route('task.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="assigned_to">Assigned To</label>
                <select name="assigned_to_id" id="assigned_to" class="form-control" required>

                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="assigned_by">Assigned By</label>
                <select name="assigned_by_id" id="assigned_by" class="form-control" required>

                    @foreach ($admins as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>
    </div>
@endsection
