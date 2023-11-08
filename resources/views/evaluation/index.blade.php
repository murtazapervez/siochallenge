@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Evaluation') }}</div>

                    <div class="card-body">
                        <div class="row">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>

                        <div class="row mt-4">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Total Time Spent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    

<script type="text/javascript">
    $(function () {
        
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('evaluation') }}",
          columns: [
              {data: 'username', name: 'username'},
              {data: 'total_time_spent_in_hours', name: 'total_time_spent_in_hours'},
          ]
      });
        
    });
  </script>
@endpush
