<h1>MYO Slot Settings</h1>

<h3>Basic Information</h3>
    <div class="form-group">
        {!! Form::label('Name') !!} {!! add_help('Enter a descriptive name for the type of character this slot can create, e.g. Rare MYO Slot. This will be listed on the MYO slot masterlist.') !!}
        {!! Form::text('name', $tag->getData()['name'], ['class' => 'form-control']) !!}
    </div>

<div class="form-group">
    {!! Form::label('Description (Optional)') !!} 
    @if($isMyo)
        {!! add_help('This section is for making additional notes about the MYO slot. If there are restrictions for the character that can be created by this slot that cannot be expressed with the options below, use this section to describe them.') !!}
    @else
        {!! add_help('This section is for making additional notes about the character and is separate from the character\'s profile (this is not editable by the user).') !!}
    @endif
    {!! Form::textarea('description', $tag->getData()['description'], ['class' => 'form-control wysiwyg']) !!}
</div>

<div class="form-group">
    {!! Form::checkbox('is_visible', 1, $tag->getData()['is_visible'], ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_visible', 'Is Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Turn this off to hide the '.($isMyo ? 'MYO slot' : 'character').'. Only mods with the Manage Masterlist power (that\'s you!) can view it - the owner will also not be able to see the '.($isMyo ? 'MYO slot' : 'character').'\'s page.') !!}
</div>

<h3>Transfer Information</h3>

<div class="alert alert-info">
    These are displayed on the MYO slot's profile, but don't have any effect on site functionality except for the following: 
    <ul>
        <li>If all switches are off, the MYO slot cannot be transferred by the user (directly or through trades).</li>
        <li>If a transfer cooldown is set, the MYO slot also cannot be transferred by the user (directly or through trades) until the cooldown is up.</li>
    </ul>
</div>
<div class="form-group">
    {!! Form::checkbox('is_giftable', 1, $tag->getData()['is_giftable'], ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_giftable', 'Is Giftable', ['class' => 'form-check-label ml-3']) !!}
</div>
<div class="form-group">
    {!! Form::checkbox('is_tradeable', 1, $tag->getData()['is_tradeable'], ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
    {!! Form::label('is_tradeable', 'Is Tradeable', ['class' => 'form-check-label ml-3']) !!}
</div>
<div class="form-group">
    {!! Form::checkbox('is_sellable', 1, $tag->getData()['is_sellable'], ['class' => 'form-check-input', 'data-toggle' => 'toggle', 'id' => 'resellable']) !!}
    {!! Form::label('is_sellable', 'Is Resellable', ['class' => 'form-check-label ml-3']) !!}
</div>
<div class="card mb-3" id="resellOptions">
    <div class="card-body">
        {!! Form::label('Resale Value') !!} {!! add_help('This value is publicly displayed on the MYO slot\'s page.') !!}
        {!! Form::text('sale_value', $tag->getData()['sale_value'], ['class' => 'form-control']) !!}
    </div>
</div>

<h3>Traits</h3>

<div class="form-group">
    {!! Form::label('Species') !!} @if($isMyo) {!! add_help('This will lock the slot into a particular species. Leave it blank if you would like to give the user a choice.') !!} @endif
    {!! Form::select('species_id', $specieses, old('species_id'), ['class' => 'form-control', 'id' => 'species']) !!}
</div>

<div class="form-group" id="subtypes">
    {!! Form::label('Subtype (Optional)') !!} @if($isMyo) {!! add_help('This will lock the slot into a particular subtype. Leave it blank if you would like to give the user a choice, or not select a subtype. The subtype must match the species selected above, and if no species is specified, the subtype will not be applied.') !!} @endif
    {!! Form::select('subtype_id', $subtypes, old('subtype_id'), ['class' => 'form-control disabled', 'id' => 'subtype']) !!}
</div>

<div class="form-group">
    {!! Form::label('Character Rarity') !!} @if($isMyo) {!! add_help('This will lock the slot into a particular rarity. Leave it blank if you would like to give the user more choices.') !!} @endif
    {!! Form::select('rarity_id', $rarities, old('rarity_id'), ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('Traits') !!} @if($isMyo) {!! add_help('These traits will be listed as required traits for the slot. The user will still be able to add on more traits, but not be able to remove these. This is allowed to conflict with the rarity above; you may add traits above the character\'s specified rarity.') !!} @endif
    <div id="featureList">
    </div>
    <div><a href="#" class="btn btn-primary" id="add-feature">Add Trait</a></div>
    <div class="feature-row hide mb-2">
        {!! Form::select('feature_id[]', $features, null, ['class' => 'form-control mr-2 feature-select', 'placeholder' => 'Select Trait']) !!}
        {!! Form::text('feature_data[]', null, ['class' => 'form-control mr-2', 'placeholder' => 'Extra Info (Optional)']) !!}
        <a href="#" class="remove-feature btn btn-danger mb-2">×</a>
    </div>
</div>
@if($stats)
<h3>Stats</h3>
<p class="alert alert-info">If you want a character to have different stats from the default, set them here. Else, leave it as default</p>
<div class="form-group">
    @foreach($stats as $stat)
        {!! Form::label($stat->name) !!}
        {!! Form::number('stats['.$stat->id.']', $stat->default, ['class' => 'form-control m-1',]) !!}
    @endforeach
</div>
@endif


@section('scripts')
@parent
@include('widgets._character_create_options_js')
@endsection