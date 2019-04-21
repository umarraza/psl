@extends('layouts.Admin')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">Edit Series</h1>
        <div class="pull-right">
            <a href="{{ url('view-all-players') }}" type="button" class="btn btn-danger">Back</a>
        </div>
    </div> 

    <form class="form-horizontal" method="post" action="{{url('update-player')}}">
        {{ csrf_field() }}
        <div class="box-body">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Player Name:</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="id" name="id" required="true" value="{{$player->id}}">
                    <input type="text" class="form-control" id="name" name="name" placeholder=""  value="{{$player->name}}">
                </div>
            </div>
            <div class="form-group">
                <label for="designation" class="col-sm-2 control-label">Player Name:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="designation" name="designation"  placeholder=""  value="{{$player->designation}}">
                </div>
            </div>
            <div class="form-group">
                <label for="nameOfTeam" class="col-sm-2 control-label">Name of Team:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nameOfTeam" name="nameOfTeam"  placeholder=""  value="{{$player->nameOfTeam}}">
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-info pull-right">Update</button>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-md-4"></div>
        <div class="col-md-4">
        @if ($errors->any())
            <div class="notification alert alert-danger" role="alert"">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ @error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        </div>
    <div class="col-md-4"></div>
</div>
@endsection
