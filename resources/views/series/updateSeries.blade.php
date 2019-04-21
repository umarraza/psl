@extends('layouts.Admin')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h1 class="box-title">Edit Series</h1>
        <div class="pull-right">
            <a href="{{ url('view-all-series') }}" type="button" class="btn btn-danger">Back</a>
        </div>
    </div> 

    <form class="form-horizontal" method="post" action="{{url('update-series')}}">
        {{ csrf_field() }}
        <div class="box-body">
            <div class="form-group">
                <label for="seriesName" class="col-sm-2 control-label">Series Name:</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="id" name="id" required="true" value="{{$series->id}}">
                    <input type="text" class="form-control input {{ $errors->has('seriesName') ? 'is-danger'  :  '' }}" id="seriesName" name="seriesName" placeholder=""  value="{{$series->seriesName}}">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Active/Inactive:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input {{ $errors->has('seriesName') ? 'is-danger'  :  '' }}" id="status" name="status"  placeholder=""  value="{{$series->status}}">
                </div>
            </div>
            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Series Type:</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input {{ $errors->has('seriesName') ? 'is-danger'  :  '' }}" id="type" name="type"  placeholder=""  value="{{$series->type}}">
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
