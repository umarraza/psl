@extends('layouts.Admin')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create New Match</h3>
                        <div class="pull-right">
                            <a href="{{ url('view-all-matches/$id') }}" type="button" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{url('new-match')}}">
                {{ csrf_field() }}
                <div class="box-body">

                {{--  <div class="form-group">
                    <label for="exampleFormControlSelect1">Team A:</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                        @foreach ($allTeams as $team)
                            <option>{{$team->team}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Example select</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                        @foreach ($allTeams as $team)
                            <option>{{$team->team}}</option>
                        @endforeach
                    </select>
                </div>  --}}

                    <div class="form-group">
                        <label for="teamA">Team A:</label>
                        <input type="text" class="form-control" id="teamA" name="teamA" placeholder="Team A">
                    </div>
                    <div class="form-group">
                            <label for="teamB">Team B:</label>
                            <input type="text" class="form-control" id="teamA" name="teamB" placeholder="Team B">
                    </div>
                    <div class="form-group">
                        <label for="unique_id">Unique Id:</label>
                        <input type="text" class="form-control" id="unique_id" name="unique_id" placeholder="Unique Id">
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="text" class="form-control" id="date" name="date" placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label for="dateTimeGMT">Date Time GMT:</label>
                        <input type="text" class="form-control" id="dateTimeGMT" name="dateTimeGMT" placeholder="Date Time GMT">
                    </div>
                    {{--  <div class="form-group">
                        <label for="type">Type:</label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="Type">
                    </div>
                    <div class="form-group">
                        <label for="squad">Squad:</label>
                        <input type="text" class="form-control" id="squad" name="squad" placeholder="Squad">
                    </div>  --}}
                    <div class="form-group">
                        <label for="matchStarted">Match Started:</label>
                        <input type="text" class="form-control" id="matchStarted" name="matchStarted" placeholder="Match Started">
                    </div>
                    <input type="hidden" class="form-control" id="type" id="id" name="seriesId" value="{{ $id }}" placeholder="ODIs/T20/Test/Wolrd Cup">
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </section> <!-- /.section -->
@endsection
