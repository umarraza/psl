@extends('layouts.Admin')

@section('content')

<div class="box box-info">

    <div class="box-header">
        <h3 class="box-title">All Teams</h3>
        <div class="pull-right">
            <a href="{{ url('view-all-series') }}" type="button" class="btn btn-danger">Back</a>
            <a href="{{ url('create-team-form/'.$id) }}" type="button" class="btn btn-primary">Add New</a>
        </div>
    </div>
    
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Team Name:</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @php $count=1; @endphp
                @foreach($teams as $team)
                    <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $team->team }}</td>
                        <td>{{ $team->image }}</td>
                        <td>
                            <a href="{{url('/update-team-form/'.$team->id)}}" type="button" class="btn btn-warning">Edit</a>
                            <a href="{{url('/delete-team/'.$team->id)}}" type="button" class="btn btn-danger">Delete</a>
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