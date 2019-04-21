@extends('layouts.Admin')

@section('content')


<div class="box box-info">

    <div class="box-header">
        <h3 class="box-title">All Series</h3>
        <div class="pull-right">
            <a href="{{ url('create-series') }}" type="button" class="btn btn-primary">Add New</a>
        </div>
    </div>
    
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Series Name:</th>
                    <th>Active/Inactive</th>
                    <th>Series Type:</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                  @php $count=1; @endphp
                  @foreach($allSeries as $series)
                      <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $series->seriesName }}</td>
                            <td>{{ $series->status }}</td>
                            <td>{{ $series->type }}</td>
                            <td>
                                <a href="{{url('/update-series-form/'.$series->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <a href="{{url('/view-all-matches/'.$series->id)}}" type="button" class="btn btn-info">View Matches</a>
                                <a href="{{url('/delete-series/'.$series->id)}}" type="button" class="btn btn-danger">Delete</a>

                            </td>
                      </tr>
                      @php $count++; @endphp
                  @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>

<section class="content">
    <div class="row">
        <div class="col-lg-6 col-xs-5">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $noOfSeries }}</h3>
                    <p>Total Series</p>
                    <div class="icon">
                        <i class="glyphicon glyphicon-star"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-xs-5">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $noOfMatches }}</h3>
                    <p>Total Matches</p>
                    <div class="icon">
                        <i class="glyphicon glyphicon-star"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection