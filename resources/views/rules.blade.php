@extends('layouts.Admin')

@section('content')

<div class="box box-info">

    <div class="box-header">
        <h3 class="box-title">All Rules</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped" style="background-color: rgba(220,220,220);">
            <thead>
                <tr>
                    <th><h4>Sr#</h4></th>
                    <th><h4>Condition</h4></th>
                    <th><h4>Points</h4></th>
                    <th><h4>Update Points<h4></th>
                </tr>
            </thead>
            <tbody>
                @php $count=1; @endphp
                @foreach($rules as $rule)
                    <tr>
                        <td><h5>{{ $count }}</h5></td>
                        <td><h5>{{ $rule->condition }}</h5></td>
                        <td><h5>{{ $rule->points }}<h5></td>
                        <td><a href="{{url('/update-rule-form/'.$rule->id)}}" type="button" class="btn btn-primary pull-center">Edit</a></td>
                    </tr>
                    @php $count++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
</div>

@endsection