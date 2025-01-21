@extends('layout.admin')

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
            <!-- General Statistics Chart -->
            <div class="col-xs-12 col-sm-4">
                <div class="card">
                    <div class="card-header">إحصائيات عامة</div>
                    <div class="card-body">
                        <canvas id="analyticsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Cadre Statistics Chart -->
            <div class="col-xs-12 col-sm-4">
                <div class="card">
                    <div class="card-header">هيئة التربية (حسب الاطار)</div>
                    <div class="card-body">
                        <canvas id="analyticsByCadre"></canvas>
                    </div>
                </div>
            </div>

            <!-- Articles Statistics Chart -->
            <div class="col-xs-12 col-sm-4">
                <div class="card">
                    <div class="card-header">ادارة المقالات</div>
                    <div class="card-body">
                        <canvas id="analyticsArticles"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Charts for Occurrences -->
        <div class="row mt-2">
            <!-- Required Commune Chart -->
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="card-header">تكرار الجماعات المطلوبة</div>
                    <div class="card-body">
                        <canvas id="requiredCommuneChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Required Dir Chart -->
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="card-header">تكرار المديريات المطلوبة</div>
                    <div class="card-body">
                        <canvas id="requiredDirChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Required Aref Chart -->
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="card-header">تكرار الأكاديميات المطلوبة</div>
                    <div class="card-body">
                        <canvas id="requiredArefChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Current Commune Chart -->
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="card-header">تكرار الجماعات المطلوبة</div>
                    <div class="card-body">
                        <canvas id="currentCommuneChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Current Dir Chart -->
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="card-header">تكرار المديريات الحالة للاعضاء</div>
                    <div class="card-body">
                        <canvas id="currentDirChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Current Aref Chart -->
            <div class="col-xs-12 col-sm-6">
                <div class="card">
                    <div class="card-header">تكرار الأكاديميات الحالة للاعضاء</div>
                    <div class="card-body">
                        <canvas id="currentArefChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // General Statistics Chart
            const ctx = document.getElementById('analyticsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Offers', 'Users', 'Bids'],
                    datasets: [{
                        label: 'إحصائيات عامة',
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
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Articles Statistics Chart
            const ctx1 = document.getElementById('analyticsArticles').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['المقالات', 'التعديلات'],
                    datasets: [{
                        label: 'إحصائيات المدونة',
                        data: [{{ $articlesCount }}, {{ $articlesEdits }}],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Cadre Statistics Chart
            const ctx2 = document.getElementById('analyticsByCadre').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['الابتدائي', 'الاعدادي', 'التأهيلي'],
                    datasets: [{
                        label: 'الابتدائي',
                        data: [{{ $tPrimaryOffersCount }}, {{ $tMiddleOffersCount }}, {{ $tSecondaryOffersCount }}],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
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
                    responsive: true
                }
            });

            // Chart for Required Commune
            const ctxRequiredCommune = document.getElementById('requiredCommuneChart').getContext('2d');
            new Chart(ctxRequiredCommune, {
                type: 'bar',
                data: {
                    labels: @json($requiredCommuneCounts->pluck('required_commune')),
                    datasets: [{
                        label: 'تكرار الجماعات المطلوبة',
                        data: @json($requiredCommuneCounts->pluck('count')),
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart for Required Dir
            const ctxRequiredDir = document.getElementById('requiredDirChart').getContext('2d');
            new Chart(ctxRequiredDir, {
                type: 'bar',
                data: {
                    labels: @json($requiredDirCounts->pluck('required_dir')),
                    datasets: [{
                        label: 'تكرار المديريات المطلوبة',
                        data: @json($requiredDirCounts->pluck('count')),
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart for Required Aref
            const ctxRequiredAref = document.getElementById('requiredArefChart').getContext('2d');
            new Chart(ctxRequiredAref, {
                type: 'bar',
                data: {
                    labels: @json($requiredArefCounts->pluck('required_aref')),
                    datasets: [{
                        label: 'تكرار الاكاديميات المطلوبة',
                        data: @json($requiredArefCounts->pluck('count')),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart for Current Commune
            const ctxCurrentCommune = document.getElementById('currentCommuneChart').getContext('2d');
            new Chart(ctxCurrentCommune, {
                type: 'bar',
                data: {
                    labels: @json($currentCommuneCounts->pluck('current_commune')),
                    datasets: [{
                        label: 'تكرار الجماعات الحالة',
                        data: @json($currentCommuneCounts->pluck('count')),
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart for Current Dir
            const ctxCurrentDir = document.getElementById('currentDirChart').getContext('2d');
            new Chart(ctxCurrentDir, {
                type: 'bar',
                data: {
                    labels: @json($currentDirCounts->pluck('current_dir')),
                    datasets: [{
                        label: 'تكرار المديريات الحالة',
                        data: @json($currentDirCounts->pluck('count')),
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Chart for Current Aref
            const ctxCurrentAref = document.getElementById('currentArefChart').getContext('2d');
            new Chart(ctxCurrentAref, {
                type: 'bar',
                data: {
                    labels: @json($currentArefCounts->pluck('current_aref')),
                    datasets: [{
                        label: 'تكرار الاكاديميات الحالة',
                        data: @json($currentArefCounts->pluck('count')),
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
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
