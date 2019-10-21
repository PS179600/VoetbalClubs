@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Clubs</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Clubnaam</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Clubs as $Club)
                                <tr>
                                    <td><a href="{{ route('clubinfo', $Club->naam) }}">{{ $Club->naam }}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
