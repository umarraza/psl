@extends('layouts.Admin')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="pull-right">
                            <a href="{{ url('view-all-matches/'.$match->seriesId) }}" type="button" class="btn btn-danger">Back</a>
                        </div>
                    <h3 class="box-title">Create New Match</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{url('update-match')}}">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="teamA">Team A:</label>
                        <input type="text" class="form-control" id="teamA" name="teamA"  value="{{ $match->teamA }}" >
                    </div>
                    <div class="form-group">
                            <label for="teamB">Team B:</label>
                            <input type="text" class="form-control" id="teamB" name="teamB" value="{{$match->teamB}}" >
                    </div>
                    <div class="form-group">
                        <label for="unique_id">Unique Id:</label>
                        <input type="text" class="form-control" id="unique_id" name="unique_id" value="{{$match->unique_id}}" >
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="text" class="form-control" id="date" name="date" value="{{$match->date}}" >
                    </div>
                    <div class="form-group">
                        <label for="dateTimeGMT">Date Time GMT:</label>
                        <input type="text" class="form-control" id="dateTimeGMT" name="dateTimeGMT" value="{{$match->dateTimeGMT}}" >
                    </div>
                    <div class="form-group">
                        <label for="matchStarted">Match Started</label>
                        <input type="text" class="form-control" id="matchStarted" name="matchStarted" value="{{$match->matchStarted}}" >
                    </div>
                    <input type="hidden" class="form-control" id="type" id="id" name="id" value="{{ $match->id }}" >
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                </form>
            </div>
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </section> <!-- /.section -->
@endsection
