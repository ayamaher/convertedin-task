@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Top 10 users with tasks List</h2>
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <canvas id="userTaskChart" width="400" height="200"></canvas>
            </div>
            <div class="col-md-4 col-sm-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Task Count</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($topUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->tasks_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- JavaScript for Chart.js -->
    <script>
        var ctx = document.getElementById('userTaskChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($topUsers->pluck('name')) !!},
                datasets: [{
                    label: 'Task Count',
                    data: {!! json_encode($topUsers->pluck('tasks_count')) !!},
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
