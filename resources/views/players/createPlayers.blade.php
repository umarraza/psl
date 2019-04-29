@extends('layouts.Admin')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Create New Player</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{url('new-player')}}">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Player Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Player Name">
                    </div>
                    <div class="form-group">
                            <label for="designation">Player Role:</label>
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Player Role">
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Price">
                    </div>
                    <div class="form-group">
                        <label for="pid">Player Id:</label>
                        <input type="text" class="form-control" id="pid" name="pid" placeholder="pid">
                    </div>
                    <div class="form-group">
                        <label for="nameOfTeam">Team Name:</label>
                        <input type="text" class="form-control" id="nameOfTeam" name="nameOfTeam" placeholder="Name of Team">
                    </div>
                    <input type="hidden" class="form-control" id="seriesId" name="seriesId" value="{{ $seriesId }}">
                    <input type="hidden" class="form-control" id="matchId" name="matchId" value="{{ $id }}" >
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
