@extends('layouts.Admin')
@section('content')

<div class="box box-info">

    <div class="box-header">
        <h3 class="box-title">All Matches</h3>
        <div class="pull-right">
            <a href="{{ url('view-all-series') }}" type="button" class="btn btn-danger">Back</a>
            <a href="{{ url('create-matches-form/'.$id) }}" type="button" class="btn btn-primary">Add New</a>
        </div>
    </div>
    
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Team A:</th>
                    <th>Team B:</th>
                    <th>Unique Id:</th>
                    <th>Date:</th>
                    <th>Date Time GMT:</th>
                    <th>Match Started:</th>
                </tr>
            </thead>

            <tbody>
                  @php $count=1; @endphp
                  @foreach($matches as $match)
                      <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $match->teamA }}</td>
                            <td>{{ $match->teamB }}</td>
                            <td>{{ $match->unique_id }}</td>
                            <td>{{ $match->date }}</td>
                            <td>{{ $match->dateTimeGMT }}</td>
                            <td>{{ $match->matchStarted }}</td>


                            <td>
                                <a href="{{url('/update-match-form/'.$match->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <!-- <a href="{{url('/view-all-players/'.$match->id)}}" type="button" class="btn btn-info">View Players</a> -->
                                <a href="{{url('/delete-match/'.$match->id)}}" type="button" class="btn btn-danger">Delete</a>

                            </td>
                      </tr>
                      @php $count++; @endphp
                  @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>


@endsection