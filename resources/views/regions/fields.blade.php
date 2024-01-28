<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', __('models/regions.fields.name').':') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Name En Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name_en', __('models/regions.fields.name_en').':') !!}
    {!! Form::text('name_en', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(__('crud.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('regions.index') }}" class="btn btn-light">@lang('crud.cancel')</a>
</div>
