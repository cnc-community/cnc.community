@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <h3 class="mt-4">Leaderboard Manager</h3>
    </div>

    <div class="row">
        <div class="col-md-6">

            <form action="{{ route('admin.update:leaderboard') }}" method="POST">
                {{csrf_field()}}

                <p>
                    Changing the season will point the Leaderboard Sync tool to fetch a new season from Petroglyph's API.
                </p>

                <p>
                    If your new season ID exists, its safe to update. E.g check the Seasons API has "R1V1_BOARD_S_05" in the response.

                    <a href="https://coordinator.cnctdra.ea.com:6531/Coordinator/webresources/com.petroglyph.coord.leaderboard.list.query/">
                        Check Seasons API
                    </a>
                </p>

                <br />

                <div class="form-group">
                    <label for="TDactiveSeason">Tiberian Dawn - Active Season</label>
                    <select id="TDactiveSeason" name="td_active_season" class="form-control">
                        @foreach($TDSeasonsRemaining as $seasonId => $seasonName)
                        <option value="{{ $seasonId }}" {{ $seasonId == $TDActiveSeasonId ? 'selected': ''}}>
                            {{ $seasonName }} - Sync Season ID: {{ $seasonId }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="RAactiveSeason">Red Alert - Active Season</label>
                    <select id="RAactiveSeason" name="ra_active_season" class="form-control">
                        @foreach($RASeasonsRemaining as $seasonId => $seasonName)
                        <option value="{{ $seasonId }}" {{ $seasonId == $RAActiveSeasonId ? 'selected': ''}}>
                            {{ $seasonName }} - Sync Season ID: {{ $seasonId }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-primary">Save</button>
            </form>

        </div>
    </div>
</div>
@endsection