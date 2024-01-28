@extends('layouts.app')

@section('contents')
    <div class="container">
        <h2>Create a New Bill</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('bills.store') }}" method="post">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Bill Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="items" class="form-label">Items</label>
                <div class="form-data">
                    <div class="row">
                        <div class="col">
                            <label for="item_name" class="form-label">Item Name</label>
                        </div>
                        <div class="col">
                            <label for="amount" class="form-label">Amount</label>
                        </div>
                        <div class="col">
                            <a href="javascript:void(0)" class="add btn btn-default">add</a>
                        </div>
                    </div>

                    <div class="row itemdata">
                        <div class="col">
                            <input type="text" class="form-control" name="items[0][item_name]" required>
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="items[0][amount]" step="0.01" required>
                            <br>
                        </div>


                    </div>


                </div>
            </div>

            <div class="hidden counter">0</div>

            <!-- Add more rows dynamically using JavaScript if needed -->

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        var html = $(document).find('.itemdata').clone();
        html.removeClass('itemdata');

        html = '<div class="row">' + html.html() + '</div';

        $(document).on('click', '.add', function() {
            var counter = $('.counter').text();
            counter = Number(counter);
            
            html = html.replace('items['+counter+'][item_name]', 'items[' + ( counter + 1 ) + '][item_name]')
            html = html.replace('items['+counter+'][amount]', 'items[' + ( counter + 1 ) + '][amount]')
            $(document).find('.form-data').append(html);
            $('.counter').text(counter + 1);

        });
    </script>
@stop
