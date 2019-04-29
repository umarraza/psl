@extends('layouts.Admin')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Create New Team</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{url('new-team')}}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="box-body">
                    <div class="form-group">
                        <label for="team">Team Name:</label>
                        <input type="text" class="form-control" id="team" name="team" placeholder="Team Name">
                    </div>
                    <div class="form-group">
                        <label for="image"> Select team flag to upload</label>

                        <input type="file" name="image" value="image" id="image">

                        <input type="hidden" class="form-control" id="seriesId" name="seriesId" value="{{ $seriesId }}" placeholder="Active/Inactive">
                    </div>
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
