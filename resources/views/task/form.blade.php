@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">

                        {{ isset($task) ? __('Update Task') : __('Create Task') }}
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

                            @if (isset($task))
                                <form class="col-6" method="post" action="{{ route('task.update', $task->id) }}">
                                    @method('PUT')
                                @else
                                    <form action="{{ route('task.store') }}" method="POST">
                            @endif

                            @csrf
                            <div class="mb-3">
                                <label for="task_name" class="form-label">Task Name</label>
                                <input type="text" class="form-control" id="task_name" name="task_name"
                                    value="{{ old('task_name', $task->task_name ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Project ID</label>
                                <select class="form-select" aria-label="Default select example" name="project_id">
                                    <option selected>Select Project</option>
                                    @foreach ($projects as $item)
                                        <option value="{{ $item->id }}"
                                            @if (isset($task)) @if ($item->id == $task->project_id)
                                                    selected @endif
                                            @endif
                                            >{{ $item->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                {{ isset($task) ? __('Update Task') : __('Create Task') }}
                            </button>
                            </form>

                        </div>

                        @if (isset($task))
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
    @if (isset($task))
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endif
@endpush
