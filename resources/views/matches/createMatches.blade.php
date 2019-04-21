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
                    <div class="form-group">
                        <label for="teamA">Team A:</label>
                        <input type="text" class="form-control" id="teamA" name="teamA" placeholder="Team A">
                    </div>
                    <div class="form-group">
                            <label for="teamB">Team B:</label>
                            <input type="text" class="form-control" id="teamA" name="teamB" placeholder="Team B">
                    </div>
                    <div class="form-group">
                        <label for="dateTimeGMT">Date:</label>
                        <input type="text" class="form-control" id="dateTimeGMT" name="dateTimeGMT" placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label for="startingTime">Start Time</label>
                        <input type="text" class="form-control" id="startingTime" name="startingTime" placeholder="Start Time">
                    </div>
                    <div class="form-group">
                        <label for="endingTime">End Time:</label>
                        <input type="text" class="form-control" id="endingTime" name="endingTime" placeholder="End Time">
                    </div>
                    <div class="form-group">
                        <label for="format">Match Format</label>
                        <input type="text" class="form-control" id="format" name="format" placeholder="Match Format">
                    </div>
                    <div class="form-group">
                        <label for="status">Match Status</label>
                        <input type="text" class="form-control" id="status" name="status" placeholder="Match Status">
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
