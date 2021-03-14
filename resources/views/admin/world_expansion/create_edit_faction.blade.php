@extends('admin.layout')

@section('admin-title') Factions @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Factions' => 'admin/world/factions', ($faction->id ? 'Edit' : 'Create').' Faction' => $faction->id ? 'admin/world/factions/edit/'.$faction->id : 'admin/world/factions/create']) !!}

<h1>{{ $faction->id ? 'Edit' : 'Create' }} Faction
    @if($faction->id)
        ({!! $faction->displayName !!})
        <a href="#" class="btn btn-danger float-right delete-type-button">Delete Faction</a>
    @endif
</h1>

{!! Form::open(['url' => $faction->id ? 'admin/world/factions/edit/'.$faction->id : 'admin/world/factions/create', 'files' => true]) !!}

<h3>Basic Information</h3>


<div class="row mx-0 px-0">
    <div class="form-group col-md px-0 pr-md-1">
        {!! Form::label('Name*') !!}
        {!! Form::text('name', $faction->name, ['class' => 'form-control']) !!}
    </div>
    @if(isset($faction->parent_id))
        <div class="form-group col-md px-0 pr-md-1">
            {!! Form::label('Style') !!} {!! add_help('How this faction will be displayed. <br> Options are editable in the Faction model.') !!}
            {!! Form::select('style', $faction->displayStyles, isset($faction->display_style) ? $faction->display_style : null, ['class' => 'form-control selectize']) !!}
        </div>
    @endif
</div>


<div class="row mx-0 px-0">
    <div class="form-group col-12 col-md-6 px-0 pr-md-1">
        {!! Form::label('Type*') !!} {!! add_help('What type of faction is this?') !!}
        {!! Form::select('type_id', [0=>'Choose a Faction Type'] + $types, $faction->type_id, ['class' => 'form-control selectize', 'id' => 'type']) !!}
    </div>

    <div class="form-group col-12 col-md-6 px-0 px-md-1">
        {!! Form::label('Parent (Optional)') !!} {!! add_help('For instance, the parent of Paris is France. <br><strong>If left blank, this will be \'top level.\'</strong>""') !!}
        {!! Form::select('parent_id', [0=>'Choose a Parent'] + $factions, isset($faction->parent_id) ? $faction->parent_id : null, ['class' => 'form-control selectize']) !!}
    </div>
</div>

@if($user_enabled || $ch_enabled)
    <div class=" mx-0 px-0 text-center">
    @if($user_enabled)
        {!! Form::checkbox('user_faction', 1, $faction->id ? $faction->is_user_faction : 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-on' => 'Users Can Join', 'data-off' => 'Users Cannot Join']) !!}
    @endif
    @if($ch_enabled)
        {!! Form::checkbox('character_faction', 1, $faction->id ? $faction->is_character_faction : 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-on' => 'Characters Can Join', 'data-off' => 'Characters Cannot Join']) !!}
    @endif
    </div>
@endif

<div class="form-group">
    {!! Form::label('Summary (Optional)') !!}
    {!! Form::text('summary', $faction->summary, ['class' => 'form-control']) !!}
</div>

<h3>Images</h3>
<div class="form-group">
    @if($faction->thumb_extension)
        <a href="{{$faction->thumbUrl}}"  data-lightbox="entry" data-title="{{ $faction->name }}"><img src="{{$faction->thumbUrl}}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
    @endif
    {!! Form::label('Thumbnail Image (Optional)') !!} {!! add_help('This thumbnail is used on the faction type index.') !!}
    <div>{!! Form::file('image_th') !!}</div>
    <div class="text-muted">Recommended size: 200x200</div>
    @if(isset($faction->thumb_extension))
        <div class="form-check">
            {!! Form::checkbox('remove_image_th', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Thumbnail As-Is', 'data-on' => 'Remove Thumbnail Image']) !!}
        </div>
    @endif
</div>

<div class="form-group">
    @if($faction->image_extension)
        <a href="{{$faction->imageUrl}}"  data-lightbox="entry" data-title="{{ $faction->name }}"><img src="{{$faction->imageUrl}}" class="mw-100 float-left mr-3" style="max-height:125px"></a>
    @endif
    {!! Form::label('Faction Image (Optional)') !!} {!! add_help('This image is used on the faction type page as a header.') !!}
    <div>{!! Form::file('image') !!}</div>
    <div class="text-muted">Recommended size: None (Choose a standard size for all faction type header images.)</div>
    @if(isset($faction->image_extension))
        <div class="form-check">
            {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'data-off' => 'Leave Header Image As-Is', 'data-on' => 'Remove Current Header Image']) !!}
        </div>
    @endif
</div>

<h3>Description</h3>
<div class="form-group" style="clear:both">
    {!! Form::label('Description (Optional)') !!}
    {!! Form::textarea('description', $faction->description, ['class' => 'form-control wysiwyg']) !!}
</div>

<div class="form-group">
    {!! Form::checkbox('is_active', 1, $faction->id ? $faction->is_active : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_active', 'Set Active', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, the type will not be visible to regular users.') !!}
</div>

<div class="text-right">
    {!! Form::submit($faction->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {
    $('.delete-type-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/world/factions/delete') }}/{{ $faction->id }}", 'Delete Faction');
    });
    $('.selectize').selectize();
});

</script>
@endsection
