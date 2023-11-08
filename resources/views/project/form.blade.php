@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        
                        {{ (isset($project)) ? __('Update Project') : __('Create Project') }}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>


                        {{-- {{ __('You are logged in!') }} --}}

                        <div class="row">

                            @if (isset($project))
                                    <form class="col-6" method="post" action="{{ route('project.update', $project->id) }}">
                                    @method('PUT')
                                @else
                                    <form action="{{ route('project.store') }}" method="POST">
                            @endif

                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $project->title ?? '')}}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" required maxlength="255">{{ old('description', $project->description ?? '')}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="start_datetime" class="form-label">Start Datetime</label>
                                <input type="date" class="form-control" id="start_datetime" name="start_datetime" value="{{ old('start_datetime', $project->start_datetime  ?? '')}}"  required>
                            </div>
                            <div class="mb-3">
                                <label for="end_datetime" class="form-label">End Datetime</label>
                                <input type="date" class="form-control" id="end_datetime" name="end_datetime" value="{{ old('end_datetime', $project->end_datetime ?? '')}}" required>
                            </div>
                            <div class="mb-3">
                                <label for="estimated_time" class="form-label">Estimated Time</label>
                                <input type="number" class="form-control" id="estimated_time" name="estimated_time" value="{{ old('estimated_time', $project->estimated_time ?? '')}}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ (isset($project)) ? __('Update Project') : __('Create Project')}}
                            </button>
                            </form>

                        </div>

                        @if(isset($project))
                        <div class="row mt-4">
                            {{ $dataTable->table() }}
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
@if(isset($project))
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endif
@endpush
