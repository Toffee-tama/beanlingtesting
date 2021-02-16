@extends('admin.layout')

@section('admin-title') Adoptions @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Adoptions' => 'admin/data/adoptions']) !!}

<h1>Adoptions</h1>

<p>Press edit to add characters to the store.</p> 
<p>Only characters owned by {!! $adoptioncenter->displayName !!} can be added to the center. This account can be changed via the "adopts_user" Site Setting.</p>

@if(!count($adoptions))
    <p>No adoption center found.</p>
@else 
    <table class="table table-sm adoption-table">
        <tbody>
            @foreach($adoptions as $adoption)
                    <td>
                        {!! $adoption->displayName !!}
                    </td>
                    <td class="text-right">
                        <a href="{{ url('admin/data/adoptions/edit/'.$adoption->id) }}" class="btn btn-primary">Edit</a>
                    </td>
            @endforeach
        </tbody>
    </table>
@endif

@endsection