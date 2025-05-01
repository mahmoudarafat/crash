<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database Comparator</title>
    <?php
    $base_assets = asset('/');
    ?>
    <link href="{{ $base_assets . 'services/database/bootstrap.min.css' }}" rel="stylesheet">

    <style>
        .card {
            height: 250px;
            overflow-y: scroll;
        }

        .checkbox:focus {
            box-shadow: unset !important;
        }
        .apply {
            padding: 10px;
            border: 2px solid #eee;
            background: mintcream;
            width: fit-content;
            font-weight: bold;
        }
        .card-parameters {
            margin-bottom:20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            @yield('content')
        </div>
    </div>
</div>
<input id="cpy-me" type="hidden">

<script src="{{ $base_assets . 'services/database/jquery.min.js' }}"></script>
<script src="{{ $base_assets . 'services/database/clipboard.min.js' }}"></script>

<script>

    var clipboard = new ClipboardJS('.cpy');

    clipboard.on('success', function (e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);

        e.clearSelection();
        alert('Copied!');
    });

    clipboard.on('error', function (e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });


    function generateRandomString(length) {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let result = '';
        for (let i = 0; i < length; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        return result;
    }

    $(document).on('change', '#type', function () {
        var hide = $(this).find('option:selected').data('hide');
        var to_hide = false;
        if(hide == 'val') to_hide = true;
        if(to_hide) {
            $(document).find('.val').hide();  
        }else{
            $(document).find('.val').show();
        }
    });
    
    $(document).ready(function () {
        $(document).find('#type').change();
    })
    
</script>
@yield('script')
</body>
</html>
