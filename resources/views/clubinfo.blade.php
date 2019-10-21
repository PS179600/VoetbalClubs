@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Clubinfo <a href="{{ route('voetbalclubs') }}" class="btn btn-primary float-right"> &#171; Terug</a></div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Naam:</label>
                                    <input type="text" class="form-control" value="{{ $ClubsInfo->naam }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Aantal Spelers:</label>
                                    <input type="text" class="form-control" value="{{ $ClubsInfo->aantal_spelers }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Positie:</label>
                                    <input type="text" class="form-control" value="{{ $ClubsInfo->positie }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#SpelerModal">Speler Toevoegen</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width: 10%">#</th>
                                        <th style="width: 40%">Spelerselectie:</th>
                                        <th style="width: 30%">Afbeelding:</th>
                                        <th style="width: 20%">Actie:</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($Spelers as $speler)
                                        <tr>
                                            <td>{{ $speler->id }}</td>
                                            <td>{{ $speler->speler_naam }} {{ collect(request()->segments())->last() == "Topscoorders" ? " - Aantal Doelputen: " . $speler->doelpunten : "" }}</td>
                                            <td>
                                                <img src="{{ asset('images/' . ($speler->afbeelding == null ? "placeholder.jpg" : $speler->afbeelding)) }}" class="rounded-circle" alt="Player Image" width="50" height="50"/>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <form method="POST" action="{{ route('speler_verwijderen', $speler->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button style="margin-right: 5px" type="submit" class="btn btn-danger" title="Verwijder Speler">&times;</button>
                                                    </form>
                                                    <form method="POST" action="{{ route('speler_wijzigen', $speler->id) }}">
                                                        @csrf
                                                        {{--<div class="form-group">--}}
                                                            {{--<label for="spelerNaam">Speler Naam</label>--}}
                                                            {{--<input class="form-control" name="spelerNaam" value="{{ $speler->speler_naam }}" type="text"/>--}}
                                                            {{--<label for="doelpunten">Aantal Doelpunten</label>--}}
                                                            {{--<input class="form-control" name="doelpunten" value="{{ $speler->doelpunten }}" type="numer"/>--}}
                                                            {{--<label for="afbeelding">Afbeelding</label>--}}
                                                            {{--<input class="form-control" name="afbeelding" value="{{ $speler->afbeelding }}" type="file"/>--}}
                                                        {{--</div>--}}
                                                        <button type="submit" class="btn btn-primary" title="Wijzig Speler">&#9986;</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @php
                                $Filters = array('Voorhoede','Middenveld','Achterhoede','Doelman','Topscoorders','Veteranen')
                            @endphp
                            <div class="col-md-4">
                                <label>Filters:</label>@if(count(collect(request()->segments())) > 2)&nbsp;&nbsp;&nbsp;<a href="{{ route('clubinfo', $ClubsInfo->naam) }}"><small>Reset Filter</small></a>@endif<br>
                                @foreach($Filters as $filter)
                                <div class="row" style="padding: 2px;">
                                    <div class="col-md-12">
                                        <a href="{{ route('clubinfo', [$ClubsInfo->naam, $filter]) }}" class="btn btn-primary text-white col-md-12">{{ $filter }}</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="SpelerModal" tabindex="-1" role="dialog" aria-labelledby="SpelerModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Speler Toevoegen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('speler_toevoegen') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Positie:</label>
                                <select name="positie" class="custom-select">
                                    <option>Voorhoede</option>
                                    <option>Middenveld</option>
                                    <option>Achterhoede</option>
                                    <option>Doelman</option>
                                </select>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Doelpunten:</label>
                                        <input type="number" class="form-control" name="doelpunten">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Speler Foto:</label>
                                        <input type="file" class="form-control" name="afbeelding">
                                    </div>
                                </div>
                                <label>Speler Naam:</label>
                                <input type="text" class="form-control" name="speler_naam">
                                <input type="hidden" class="form-control" name="club" value="{{ $ClubsInfo->naam }}" hidden>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                        <button type="submit" class="btn btn-primary">Speler Toevoegen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
