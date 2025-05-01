@extends('procedures::master')
@section('title')
    Procedure
@endsection
@section('content')
    <div class="text-center">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="text-primary pager" style="margin-top:50px;">Show All Procedures</h1>
            </div>
            <div class="col-sm-6"> 
                <a style="margin-top:3.3em;" href="{{ route('procedures.create') }}" class="btn btn-success">Create / Test</a>
            </div>
        </div>
        <hr>
        <table class="table table-bordered">
            <thead>
                <th>#</th>
                <th>Code Parameters</th>
                <th>Your SourceCode</th>
                <th></th>
            </thead>
            <tbody>
                @foreach ($data as $procedure)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $procedure->title }}</td>
                        <td>{{ $procedure->parameters }}</td>
                        <td> <a href="{{ route('procedures.edit', $procedure->id ) }}" class="btn btn-danger">Execute </a> </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            
            $(document).on('click', '.execute', function() {
                var params = $(this).data('params');
                var id = $(this).data('id');
                var source = $(this).data('source');
                var data = {
                    _token: "{{ csrf_token() }}",
                    params: params,
                    id: id,
                    source: source
                }
            });
        })
    </script>
@endsection
