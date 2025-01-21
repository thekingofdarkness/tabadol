@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Offers Card -->
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Offers</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $offersCount }}</h5>
                    <p class="card-text">Total number of offers.</p>
                </div>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Users</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $usersCount }}</h5>
                    <p class="card-text">Total number of users.</p>
                </div>
            </div>
        </div>

        <!-- Bids Card -->
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Bids</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $bidsCount }}</h5>
                    <p class="card-text">Total number of bids.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Analytics</div>
                <div class="card-body">
                    <canvas id="analyticsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        const analyticsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Offers', 'Users', 'Bids'],
                datasets: [{
                    label: 'Count',
                    data: [{{ $offersCount }}, {{ $usersCount }}, {{ $bidsCount }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection
