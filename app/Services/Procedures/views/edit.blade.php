@extends('procedures::master')
@section('title')
    Procedure
@endsection
@section('content')
    <div class="text-center">
        <h1 class="text-primary pager" style="margin-top:50px;">Prepare Procedure: {{ $procedure->title }}</h1>
        <hr>
        <form id="edit-procedure" method="post" action="{{ route('procedures.update') }}" target="_blank">
            {{ csrf_field() }}
            <table class="table table-bordered">
                <thead>
                    <th>Query Parameters</th>
                    <th>Your Query Script</th>
                </thead>
                <tbody>
                    <tr>
                        <td style="width:45%">
                            <ul class="list-unstyled">
                                <li>
                                    <label>Execution Type:</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="test" data-hide="">Testing Only</option>
                                        <option value="update" data-hide="val">Update</option>
                                    </select>
                                    <hr> 
                                </li>
                                <li>
                                    <label>Procedure Title:</label>
                                    <input required name="id" class="form-control" value="{{ $procedure->id }}" type="hidden" />
                                    <input required name="title" class="form-control" value="{{ $procedure->title }}" />
                                    <hr>
                                </li>
                                <li>
                                    <label>Procedure Variable:</label>
                                    <input required name="leaver" class="form-control" value="{{ $procedure->leaver }}" />
                                    <hr>
                                </li>
                                <li>
                                    <label>Parameters: <a style="text-align:end;margin-left:20px;background:#eee;"
                                            class="btn btn-default add" href="javascript:void(0)">+</a></label>
                                    <div >
                                        @php $parameters = json_decode($procedure->parameters, true); @endphp
                                        <table >
                                            <tbody class="params-container">
                                            <tr>
                                                <th>Parameter Slug</th>
                                                <th>Parameter Value</th>
                                                <th>Action</th>
                                            </tr>
                                        
                                            @foreach ($parameters as $param)
                                                @php $id = rand(); @endphp
                                                <tr id="tr-{{ $id }}">
                                                    <td>
                                                        <input required name="name[{{ $param }}]"
                                                            class="form-control" value="{{ $param }}" />
                                                    </td>
                                                    <td >
                                                        <input required name="parameter[{{ $param }}]"
                                                            class="form-control val" value="" />
                                                    </td>
                                                    <td>
                                                        <span data-id="{{ $id }}" class="del btn btn-danger">X</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>    
                                    </div>
                                </li>
                            </ul>
                        </td>
                        <td style="width:55%">
                            <textarea name="source" id="source-auto" class="form-control" rows="18">{{ $procedure->source }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <a href="javascript:void(0)" id="do-save" class="btn btn-primary">Execute</a>

        <br>
        <br>
        <br>
    </div>
@endsection
@section('script')
    <script>
        
        $(document).ready(function() {
            $(document).on('click', '.add', function() {
                const id = generateRandomString(10);
                $(document).find('.params-container').append(`
                    <tr id="tr-${id}">
                        <td>
                            <input required name="new_key[${id}]"
                                class="form-control" value="" />
                        </td>
                        <td>
                            <input  required name="new_val[${id}]"
                                class="form-control val" value="" />
                        </td>
                        <td>
                            <span data-id="${id}" class="del btn btn-danger">X</span>
                        </td>
                    </tr>
                `);
                $(document).find('#type').change();
            });
            
        })
    </script>
@endsection
