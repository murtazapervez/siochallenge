@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        {{ isset($timeLog) ? __('Update Timelog') : __('Create Timelog') }}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                        </div>

                        <div class="row">

                            @if (isset($timeLog))
                                <form class="col-6" method="post" action="{{ route('timelog.update', $timeLog->id) }}">
                                    @method('PUT')
                                @else
                                    <form action="{{ route('timelog.store') }}" method="POST">
                            @endif

                            @csrf
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Time Log</label>
                                <select class="form-select" aria-label="Default select example" name="task_id">
                                    <option selected>Select Task</option>
                                    @foreach ($tasks as $item)
                                        <option value="{{ $item->id }}"

                                            @if (isset($tasks) && isset($timeLog))

                                                @if ($timeLog->task_id == $item->id)
                                                    selected
                                                @endif
                                            @endif
                                            >{{ $item->task_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="start_time" id="start_time"
                                value="{{ old('start_time', $timeLog->start_time ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">End Time</label>
                                <input type="time" class="form-control" name="end_time" id="end_time"
                                value="{{ old('end_time', $timeLog->end_time ?? '') }}">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($timeLog) ? __('Update Timelog') : __('Create Timelog') }}
                            </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
