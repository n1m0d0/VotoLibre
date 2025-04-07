<div wire:poll.10s class="p-4">
    <h2 class="text-xl font-bold mb-4">Total de Votos {{ $totalVotes }}</h2>
    <h2 class="text-xl font-bold mb-4">Votos por Partido</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Gráfico de barras -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Distribución de Votos (Barras)</h3>
            <canvas id="votesBarChart"></canvas>
        </div>

        <!-- Gráfico de pastel -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Distribución de Votos (Pastel)</h3>
            <canvas id="votesPieChart"></canvas>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('livewire:navigated', () => {
                const bar = document.getElementById('votesBarChart');
                const pie = document.getElementById('votesPieChart');

                if (!bar || !pie) return;

                const labels = @js($labels);
                const votes = @js($votes);
                const backgroundColor = @js($backgroundColor);
                const borderColor = backgroundColor.map(c => c.replace('0.7', '1'));

                // Destruir gráficos anteriores si ya existen
                if (window.barChart) window.barChart.destroy();
                if (window.pieChart) window.pieChart.destroy();

                window.barChart = new Chart(bar, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Votos',
                            data: votes,
                            backgroundColor,
                            borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                window.pieChart = new Chart(pie, {
                    type: 'doughnut',
                    data: {
                        labels,
                        datasets: [{
                            data: votes,
                            backgroundColor,
                            borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: ({
                                        label,
                                        raw,
                                        dataset
                                    }) => {
                                        const total = dataset.data.reduce((acc, val) => acc + val, 0);
                                        const percent = Math.round((raw / total) * 100);
                                        return `${label}: ${raw} (${percent}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
