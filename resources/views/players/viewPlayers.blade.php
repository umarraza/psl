@extends('layouts.Admin')
@section('content')

<div class="box box-info">

    <div class="box-header">
        <h3 class="box-title">All Players</h3>
        <div class="pull-right">
            <a href="{{ url('create-player-form/'.$id) }}" type="button" class="btn btn-primary">Add New</a>
        </div>
    </div>
    
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        
            <thead>
                <tr>
                    <th>Sr#</th>
                    <th>Player Name:</th>
                    <th>Player Role:</th>
                    <th>Team Name:</th>
                </tr>
            </thead>

            <tbody>
                  @php $count=1; @endphp
                  @foreach($players as $player)
                      <tr>
                            <td>{{ $count }}</td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->designation }}</td>
                            <td>{{ $player->nameOfTeam }}</td>
                            <td>
                                <a href="{{url('/update-player-form/'.$player->id)}}" type="button" class="btn btn-warning">Edit</a>
                                <a href="{{url('/delete-player/'.$player->id)}}" type="button" class="btn btn-danger">Delete</a>
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