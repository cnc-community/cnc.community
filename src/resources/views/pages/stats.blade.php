@extends('layouts.app')

@section('title', 'C&C Games Statistics')
@section('description', 'Find all the official C&C Online and C&C Community online game statistics')
@section('page-class', 'game-stats')

@section('hero-video')
    <div class="video" style="background-image: url('/assets/images/creators.jpg')">
    </div>
@endsection

@section('hero')
    <div class="content center">
        <h1 class="text-uppercase">
            C&amp;C Games Statistics
        </h1>
        <p class="lead">
            <strong><span class="js-total-online"></span></strong> players online C&amp;C Games &amp; mods
        </p>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="main-content">
            <h3>Official C&amp;C Titles - Players Online</h3>
            <div class="items-wrap-old">
                <?php foreach ($games as $game) : ?>
                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>
                <?php
                new App\Http\CustomView\Components\OnlineBox(($title = $gameByAbbreviation['name']), ($url = $gameByAbbreviation['url']), ($logo = $gameByAbbreviation['logo']), ($externalLink = $gameByAbbreviation['external_link']), ($gameAbrev = $game->getAbbreviation()), ($onlineCount = $game->getOnlineCount()));
                ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="main-content">
            <h3>C&amp;C Mods - Players Online</h3>
            <div class="items-wrap-old">
                <?php foreach ($mods as $game) : ?>
                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>
                <?php
                new App\Http\CustomView\Components\OnlineBox(($title = $gameByAbbreviation['name']), ($url = $gameByAbbreviation['url']), ($logo = $gameByAbbreviation['logo']), ($externalLink = $gameByAbbreviation['external_link']), ($gameAbrev = $game->getAbbreviation()), ($onlineCount = $game->getOnlineCount()));
                ?>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="main-content">
            <h3>C&amp;C Community Games - Players Online</h3>
            <div class="items-wrap-old">
                <?php foreach ($standalone as $game) : ?>
                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>
                <?php
                new App\Http\CustomView\Components\OnlineBox(($title = $gameByAbbreviation['name']), ($url = $gameByAbbreviation['url']), ($logo = $gameByAbbreviation['logo']), ($externalLink = $gameByAbbreviation['external_link']), ($gameAbrev = $game->getAbbreviation()), ($onlineCount = $game->getOnlineCount()));
                ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="section game-stats-chart">
        <div class="main-content">
            <h3>C&amp;C Stats - Players Online</h3>

            <canvas id="chart"></canvas>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const datasets = [
            <?php foreach ($graphData as $gameAbbrev => $data) : ?> {
                label: "<?php echo $data['label']; ?>",
                data: [
                    <?php foreach ($data["data"] as $d) : ?> {
                        t: moment.utc("<?php echo $d['t']; ?>"),
                        y: <?php echo $d['y']; ?>
                    },
                    <?php endforeach; ?>
                ],
                backgroundColor: '<?php echo $data['backgroundColor']; ?>',
                borderColor: '<?php echo $data['borderColor']; ?>',
                borderWidth: 3
            },
            <?php endforeach; ?>
        ];

        const myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: datasets
            },
            options: {
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            unit: 'day'
                        },
                        scaleLabel: {
                            display: true,
                            labelString: '',
                            fontSize: 16,
                            fontStyle: "bold"
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Players Online',
                            fontSize: 16,
                            fontStyle: "bold"
                        }
                    }]
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        fontSize: 14,
                        defaultFontFamily: "Open Sans, sans-serif",
                        fontColor: "#868383",
                        padding: 15,
                    }
                }
            }
        });
    </script>
@endsection
