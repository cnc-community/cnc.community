@extends('layouts.app')

@section('title', 'C&C Games Statistics')
@section('description', 'Find all the official C&C Online and C&C Community online game statistics')
@section('page-class', 'game-stats')

@section('hero-video')
    <div class="video" style="background-image: url('{{ Vite::asset('resources/assets/images/creators.jpg') }} ')">
    </div>
@endsection

@section('hero')
    <div class="content center">
        <h1 class="text-uppercase">
            C&amp;C Games Statistics
        </h1>
        <p class="lead">
            Players online C&amp;C Games &amp; mods
        </p>
    </div>
@endsection

@section('content')
    <section class="section">
        <div class="main-content">
            <h3>Official C&amp;C Titles - Players Online</h3>
            <div class="items-wrap-old">
                @foreach ($games as $game)
                    <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>

                    @include('components.online-box', [
                        'title' => $gameByAbbreviation['name'],
                        'url' => $gameByAbbreviation['url'],
                        'logo' => $gameByAbbreviation['logo'],
                        'externalLink' => $gameByAbbreviation['external_link'],
                        'gameAbrev' => $game->getAbbreviation(),
                        'onlineCount' => $game->getOnlineCount(),
                        'steamInGameCount' => $game->steam_players_online,
                        'onlineService' => $gameByAbbreviation['online_service'],
                    ])
                @endforeach
            </div>
        </div>

        <div class="main-content">
            <h3>C&amp;C Mods - Players Online</h3>
            <div class="items-wrap-old">
                @foreach ($mods as $game)
                    <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>

                    @include('components.online-box', [
                        'title' => $gameByAbbreviation['name'],
                        'url' => $gameByAbbreviation['url'],
                        'logo' => $gameByAbbreviation['logo'],
                        'externalLink' => $gameByAbbreviation['external_link'],
                        'gameAbrev' => $game->getAbbreviation(),
                        'onlineCount' => $game->getOnlineCount(),
                        'steamInGameCount' => $game->steam_players_online,
                        'onlineService' => $gameByAbbreviation['online_service'],
                    ])
                @endforeach
            </div>
        </div>

        <div class="main-content">
            <h3>C&amp;C Community Games - Players Online</h3>
            <div class="items-wrap-old">
                @foreach ($standalone as $game)
                    <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->getAbbreviation()); ?>

                    @include('components.online-box', [
                        'title' => $gameByAbbreviation['name'],
                        'url' => $gameByAbbreviation['url'],
                        'logo' => $gameByAbbreviation['logo'],
                        'externalLink' => $gameByAbbreviation['external_link'],
                        'gameAbrev' => $game->getAbbreviation(),
                        'onlineCount' => $game->getOnlineCount(),
                        'steamInGameCount' => $game->steam_players_online,
                        'onlineService' => $gameByAbbreviation['online_service'],
                    ])
                @endforeach
            </div>
        </div>
    </section>

    <section id="stats" class="section game-stats-chart">
        <div class="main-content">
            <h3>C&amp;C Stats - Players Online</h3>

            <div class="stats-filter">
                <div>
                    <button id="jsDateTimePicker" class="btn btn-secondary btn-sm">Filter Start Date</button>
                </div>
                <div style="margin-left:1rem;">
                    <a class="btn btn-outline btn-sm" href="?{{ $officialGamesUrlOnly }}#stats">Official Games only</a>
                </div>
                <div style="margin-left:1rem;">
                    <a class="btn btn-outline btn-sm" href="?{{ $modGamesUrlOnly }}#stats">C&C Mods only</a>
                </div>
                <div style="margin-left:1rem;">
                    <a class="btn btn-outline btn-sm" href="?{{ $standaloneUrlOnly }}#stats">C&C Community Games only</a>
                </div>
                <div style="margin-left:1rem;">
                    <a class="btn btn-outline btn-sm" href="?{{ $steamInGameOnly }}#stats">C&C Steam In Game only</a>
                </div>
            </div>

            <div>
                <div>
                    <select id="filter-by-game" multiple placeholder="Filter by game?" class="search-dropdown">
                        <optgroup label="Official C&C Titles">
                            @foreach ($games as $game)
                                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($game->abbrev); ?>
                                <?php $selected = in_array($gameByAbbreviation['name'], $selectedLabels) ? 'selected' : ''; ?>

                                <option @if ($selected) selected @endif value="<?php echo $gameByAbbreviation['name']; ?>" data-src="<?php echo $gameByAbbreviation['logo']; ?>">
                                    <?php echo $gameByAbbreviation['name']; ?>
                                </option>
                            @endforeach
                        </optgroup>

                        <optgroup label="C&C Mods">
                            @foreach ($mods as $mod)
                                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($mod->abbrev); ?>
                                <?php $selected = in_array($gameByAbbreviation['name'], $selectedLabels) ? 'selected' : ''; ?>

                                <option @if ($selected) selected @endif value="<?php echo $gameByAbbreviation['name']; ?>" data-src="<?php echo $gameByAbbreviation['logo']; ?>">
                                    <?php echo $gameByAbbreviation['name']; ?>
                                </option>
                            @endforeach
                        </optgroup>

                        <optgroup label="C&C Community Games">
                            @foreach ($standalone as $communityGame)
                                <?php $gameByAbbreviation = App\Constants::getGameFromOnlineAbbreviation($communityGame->abbrev); ?>
                                <?php $selected = in_array($gameByAbbreviation['name'], $selectedLabels) ? 'selected' : ''; ?>

                                <option @if ($selected) selected @endif value="<?php echo $gameByAbbreviation['name']; ?>" data-src="<?php echo $gameByAbbreviation['logo']; ?>">
                                    <?php echo $gameByAbbreviation['name']; ?>
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
            </div>

            <div style="margin-top:2rem; margin-bottom:2rem;">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </section>
@endsection

@section('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
                animation: false,
                spanGaps: true,
                scales: {
                    xAxes: [{
                        type: 'time',
                        time: {
                            unit: 'day',
                            min: new Date('2024-02-25').valueOf(),
                            max: new Date().valueOf()
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
                },
            }
        });

        // Show last 7 days graph data
        var currentDate = new Date();
        var minDate = new Date();
        minDate.setDate(currentDate.getDate() - 91); // 3months-ish

        flatpickr("#jsDateTimePicker", {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: minDate,
            maxDate: new Date().toISOString().split('T')[0],
            onChange: function(selectedDates, dateStr, instanc) {
                updateTimeScale(selectedDates[0], new Date());
            }
        });


        // Define the updateTimeScale function to update the time scale of the chart
        function updateTimeScale(minDate, maxDate) {
            myLineChart.options.scales.xAxes[0].time.min = minDate.valueOf();
            myLineChart.options.scales.xAxes[0].time.max = maxDate.valueOf();
            myLineChart.update();
        }

        // Function to filter datasets based on selected labels
        function filterDatasetsByLabels(labels) {
            return datasets.filter(dataset => labels.includes(dataset.label));
        }

        // Update chart with filtered datasets
        function updateChart(labels) {
            const filteredDatasets = filterDatasetsByLabels(labels);
            myLineChart.data.datasets = filteredDatasets;
            myLineChart.update();
        }

        // Event listener for dropdown change
        document.getElementById('filter-by-game').addEventListener('change', function() {
            const selectedLabels = Array.from(this.selectedOptions).map(option => option.value);
            updateChart(selectedLabels);
        });

        new TomSelect('#filter-by-game', {
            maxItems: 200,
            maxOptions: 200,
            persist: true,
            plugins: {
                remove_button: {
                    title: 'Remove this item',
                }
            },
            render: {
                option: function(data, escape) {
                    return `<div><img class="me-2" src="${data.src}" style="width:100px;"></div>`;
                },
                item: function(item, escape) {
                    return `<div><img class="me-2" src="${item.src}" style="width:80px;"></div>`;
                }
            }
        });


        // Show last 21 days graph data
        var currentDate = new Date();
        var pastDate = new Date();
        pastDate.setDate(currentDate.getDate() - 21);
        updateTimeScale(pastDate, currentDate);
    </script>

    <script>
        // Function to update URL query parameters
        function updateURLParams(selectedLabels, startDate) {
            const params = new URLSearchParams(window.location.search);
            params.delete('filteredGames'); // Remove previous 'filteredGames' parameter
            params.delete('startDate'); // Remove previous 'startDate' parameter

            if (selectedLabels.length > 0) {
                params.append('filteredGames', selectedLabels.join(',')); // Append selected labels as 'filteredGames' parameter
            }

            if (startDate) {
                params.append('startDate', startDate);
            }

            const newURL = window.location.pathname + '?' + params.toString();
            window.history.pushState({}, '', newURL); // Update URL without reloading page
        }

        // Event listener for dropdown change
        document.getElementById('filter-by-game').addEventListener('change', function() {
            const selectedLabels = Array.from(this.selectedOptions).map(option => option.value);
            const startDate = document.getElementById('jsDateTimePicker').value;
            updateChart(selectedLabels);
            updateURLParams(selectedLabels, startDate);
            if (selectedLabels.length === 0) {
                initializeChartWithSelectedLabels();
            } else {
                updateChart(selectedLabels);
            }
        });

        // Get selected labels from URL query parameters
        function getSelectedLabelsFromURL() {
            const params = new URLSearchParams(window.location.search);
            const labelsParam = params.get('filteredGames');

            if (labelsParam) {
                return labelsParam.split(',');
            } else {
                return [];
            }
        }

        // Get start date from URL query parameters
        function getStartDateFromURL() {
            const params = new URLSearchParams(window.location.search);
            return params.get('startDate');
        }

        // Function to get all labels
        function getAllLabels() {
            const allLabels = [];
            datasets.forEach(dataset => allLabels.push(dataset.label));
            return allLabels;
        }

        // Initialize chart with selected labels and start date from URL parameters
        function initializeChartWithSelectedLabels() {
            const selectedLabels = getSelectedLabelsFromURL();
            const startDate = getStartDateFromURL();

            if (selectedLabels.length === 0) {
                updateChart(getAllLabels()); // Show all games in the chart
            } else {
                const filteredDatasets = filterDatasetsByLabels(selectedLabels);
                myLineChart.data.datasets = filteredDatasets;
                myLineChart.update();
            }

            if (startDate) {
                document.getElementById('jsDateTimePicker').value = startDate;
            }
        }

        initializeChartWithSelectedLabels();
    </script>

@endsection
