@extends('layouts.Admin')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="pull-right">
                            <a href="{{ url('view-all-matches/'.$match->id) }}" type="button" class="btn btn-danger">Back</a>
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
                        <label for="dateTimeGMT">Date:</label>
                        <input type="text" class="form-control" id="dateTimeGMT" name="dateTimeGMT" value="{{$match->dateTimeGMT}}" >
                    </div>
                    <div class="form-group">
                        <label for="startingTime">Start Time</label>
                        <input type="text" class="form-control" id="startingTime" name="startingTime" value="{{$match->startingTime}}" >
                    </div>
                    <div class="form-group">
                        <label for="endingTime">End Time:</label>
                        <input type="text" class="form-control" id="endingTime" name="endingTime" value="{{$match->endingTime}}" >
                    </div>
                    <div class="form-group">
                        <label for="format">Match Format</label>
                        <input type="text" class="form-control" id="format" name="format" value="{{$match->format}}" >
                    </div>
                    <div class="form-group">
                        <label for="status">Match Status</label>
                        <input type="text" class="form-control" id="status" name="status" value="{{$match->status}}" >
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
