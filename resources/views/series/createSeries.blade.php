@extends('layouts.Admin')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    <h3 class="box-title">Create New Series</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="post" action="{{url('new-series')}}">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group">
                        <label for="seriesName">Series Name:</label>
                        <input type="text" class="form-control" id="seriesName" name="seriesName" placeholder="Series Name">
                    </div>
                    <div class="form-group">
                            <label for="status">Series Status:</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="Active/Inactive">
                    </div>
                    <div class="form-group">
                        <label for="type">Series Type</label>
                        <input type="text" class="form-control" id="type" name="type" placeholder="ODIs/T20/Test/Wolrd Cup">
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
