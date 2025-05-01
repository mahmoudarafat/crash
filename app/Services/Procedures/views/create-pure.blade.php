@extends('procedures::master')
@section('title')
    Procedure
@endsection
@section('content')
    <div class="text-center">
        <h1 class="text-primary pager" style="margin-top:50px;">Create Procedure</h1>
        <hr>
        <form id="form-procedure" method="post" action="{{ route('procedures.save') }}">
            {{ csrf_field() }}
            <table class="table table-bordered">
                <thead>
                    <th>Code Parameters</th>
                    <th>Your SourceCode</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:35%">
                            <ul class="list-unstyled">
                                <li>
                                    <label>Procedure Title:</label>
                                    <input required name="title" class="form-control" />
                                    <hr>
                                </li>
                                <li>
                                    <label>Procedure Variable:</label>
                                    <input required name="leaver" class="form-control" value="" />
                                    <hr>
                                </li>
                                <li>
                                    <label>Parameters: <a style="text-align:end;margin-left:20px;background:#eee;" class="btn btn-default add" href="javascript:void(0)">+</a></label>
                                    <div class="params-container">
                                        <div class="row card-parameters">
                                            <div class="col-sm-9">
                                                <input required name="parameter[]" class="form-control" />
                                            </div>
                                            <div class="col-sm-3">
                                                <span class="del btn btn-danger">X</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </td>
                        <td style="width:65%">
                            <textarea name="source" id="source-auto" class="form-control" rows="15"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <a href="javascript:void(0)" id="do-save" class="btn btn-primary">Save</a>

    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.add', function () {
                $(document).find('.params-container').append(`<div class="row card-parameters">
                                            <div class="col-sm-9">
                                                <input required name="parameter[]" class="form-control" />
                                            </div>
                                            <div class="col-sm-3">
                                                <span class="del btn btn-danger">X</span>
                                            </div>
                                        </div>`);
            });

            $(document).on('click', '#do-save', function () {
                $(document).find('#form-procedure').submit();
            });
        })
    </script>
@endsection