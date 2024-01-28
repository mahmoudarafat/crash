<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', __('models/regions.fields.id').':') !!}
    <p>{{ $region->id }}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', __('models/regions.fields.name').':') !!}
    <p>{{ $region->name }}</p>
</div>

<!-- Name En Field -->
<div class="form-group">
    {!! Form::label('name_en', __('models/regions.fields.name_en').':') !!}
    <p>{{ $region->name_en }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', __('models/regions.fields.created_at').':') !!}
    <p>{{ $region->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', __('models/regions.fields.updated_at').':') !!}
    <p>{{ $region->updated_at }}</p>
</div>

