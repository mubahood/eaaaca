<?php
use App\Models\Utils;

use App\Models\NewsPost;
//last news post
$last_news_post = NewsPost::orderBy('id', 'desc')->first();
if (!isset($display_notice_board)) {
    $display_notice_board = false;
}

?>

<style>
    .ext-icon {
        color: rgba(0, 0, 0, 0.5);
        margin-left: 10px;
    }

    .installed {
        color: #00a65a;
        margin-right: 10px;
    }

    .card {
        border-radius: 5px;
    }

    .case-item:hover {
        background-color: rgb(254, 254, 254);
    }
</style>

<div class="card mb-4 mb-md-2 border-0">
    <!--begin::Header-->
    <div class="d-flex justify-content-between px-3 px-md-4 pt-3">
        <h3>
            <b>Requests By Status</b>
        </h3>
    </div>

    <div class="card-body py-2 py-md-3">
        <canvas id="pie" style="width: 100%;"></canvas>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-5 p-md-4">
                <h3 class="fs-30 fw-800 mb-3">ARINEA Updates</h3>
                <hr>
                <p class="fs-16 mb-4">
                    {!! $last_news_post->title !!}
                </p>
                <a href="{{ url('news-posts') }}" class="btn btn-primary btn-sm">View More</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {


        window.chartColors = {
            blue: 'rgb(14, 62, 235)',
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        var config = {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Incoming Requests',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: [
                        window.chartColors.blue,
                        'purple',
                        'red',
                        'green',
                        window.chartColors.orange,
                        window.chartColors.yellow,
                        window.chartColors.grey,
                        window.chartColors.red,
                        window.chartColors.green,
                        'black',
                        'blue',
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                title: {
                    display: false,
                    text: 'Chart.js pie Chart'
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        title: {
                            display: true,
                            text: 'Number of Requests'
                        }
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                }
            }
        };

        var ctx = document.getElementById('pie').getContext('2d');
        var chart = new Chart(ctx, config);




    });
</script>
