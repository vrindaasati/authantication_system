@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form  id="registerUser">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="first_name" id="first_name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="last_name" value="{{ old('name') }}" id="last_name" autocomplete="name" autofocus>
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" autocomplete="email"></div>
                            </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" onclick="registerUser()">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
    $(document).ready(function ($) {
        $("#registerUser").validate({
            rules: {
                first_name: "required",
                email:{
                    required:true,
                    email:true,
                    remote: {
                        url : "{{ route('check_email') }}",
                        data: {
                            email: $("input[email='email']").val()
                        },
                        dataFilter: function(data) {
                            if (data) {
                                return "\"" + "Email address already in use" + "\"";
                            } else {
                                return 'true';
                            }
                        }
                    }
                    
                }
            },
            messages: {
                first_name : "*Please enter first name",
                email : {
                    required: "*Please enter your email address",
                    email: "*Please enter valid email address",
                }

            }
        })
    })

    function registerUser(){
        var isValid = $("#registerUser").valid();
        if(!isValid){return false;}
        
        $.ajax({
            method: 'POST',
            url: "{{ route('register_user') }}",
            
            data: {
                first_name:$("input[name='first_name']").val(),
                last_name:$("input[name='last_name']").val(),
                email:$("input[name='email']").val(),
                _token:"{{ csrf_token() }}"
            },
            success: function(response) {
                if(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Hurray...',
                        text: 'Data saved successfully!',
                    }).then((result) => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                }
            },
        });
    }
    
</script>
@endsection
