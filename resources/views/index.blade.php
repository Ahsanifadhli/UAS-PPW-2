@extends('base')
@section('title','Beranda')
@section('menuberanda', 'underline decoration-4 underline-offset-7')

@section('content')
    {{-- HTML INI PERSIS 100% SAMA KODINGAN ASLIMU --}}
    <section class="p-4 bg-white rounded-lg">
        <h1 class="text-3xl font-bold text-[#C0392B] mb-6 text-center">Statistik</h1>
        <div class="mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Chart Kiri --}}
                <div>
                    <div class="flex justify-center">
                        <canvas id="chart1" class="w-full max-w-[600px]"></canvas>
                    </div>
                </div>
                {{-- Chart Kanan --}}
                <div class="flex justify-center">
                    <canvas id="chart2" class="w-full max-w-[600px]"></canvas>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    {{-- Script JS tetap dinamis ambil data dari Controller --}}
    <script src="{{ asset('plugins/chartjs-4/chart-4.5.0.js') }}"></script>

    <script>
        // === CHART 1: GENDER (Pie) ===
        const ctx1 = document.getElementById('chart1');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ["Laki-laki", "Perempuan"],
                datasets: [{
                    label: 'Jumlah',
                    // Data Dinamis
                    data: [{{ $maleCount }}, {{ $femaleCount }}],
                    backgroundColor: [
                        '#3b82f6', // Biru
                        '#ec4899'  // Pink
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Persentase Pegawai Berdasarkan Gender'
                    }
                }
            }
        });

        // === CHART 2: TOP PEKERJAAN (Bar) ===
        const ctx2 = document.getElementById('chart2').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                // Data Dinamis (Array PHP ke JS)
                labels: {!! json_encode($jobLabels) !!},
                datasets: [{
                    label: 'Jumlah Pegawai',
                    // Data Dinamis
                    data: {!! json_encode($jobTotals) !!},
                    backgroundColor: '#C0392B',
                    borderColor: '#922B21',
                    borderWidth: 1,
                    borderRadius: 4,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Top 5 Pekerjaan Dengan Jumlah Pegawai Paling Banyak'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 } // Biar angkanya bulat
                    },
                }
            }
        });
    </script>
@endpush
