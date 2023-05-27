@extends('layouts.app')

@section('content')
<div class="container">
    <h4>{{ __('User List') }}</h4>
    <div class="row justify-content-center">
        
        <table class="table table-stripped table-bordered user_datatable">
            <thead>
                <tr>
                    <th>S. No.</th>
                    <th>Fisrt Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Profile Picture</th>
                </tr>
            </thead>
        </table>
    </div>
    
</div>
@endsection
@section('javascript')
<script>
    $(function () {
        var table = $('.user_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('fetch_user_list') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'first_name', name: 'first_name'},
                {data: 'last_name', name: 'last_name'},
                {data: 'email', name: 'email'},
                {data: 'profile_pic', name: 'profile_pic',orderable: false, searchable: false},
            ]
        });
    });
</script>
@endsection