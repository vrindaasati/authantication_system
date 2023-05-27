@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                
                <div class="card-body">
                    <form id="loginUser">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>

                                
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="button" class="btn btn-primary" onclick="loginUser()">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                   
                </div>
                
            </div>
        </div>
    </div>
    <br>
    <div  class="row">
        <div class="col-md-4"></div>
        <div class="col-md-6" >
            <h5 style="display:none" id="qr_heading">Scan This QR To Get Edit Profile URL</h5>
            <div width="150" height="150" id="qrcode" ></div>
        </div>
        
    </div>
</div>
@endsection
@section('javascript')
<script>
   
    $(document).ready(function ($) {
        $("#loginUser").validate({
            rules: {
                email:"required"
            },
            messages: {
                email : "*Please enter your email address"
            }
        })
    })

    function loginUser(){
        var isValid = $("#loginUser").valid();
        if(!isValid){return false;}
        $.ajax({
            method: 'POST',
            url: "{{ route('generate_qr_code') }}",
            
            data: {
                email:$("input[name='email']").val(),
                _token : "{{ csrf_token() }}",
            },
            success: function(response) {
                if(response){
                    $("#qr_heading").css("display", "block");
                    var qrcode = new QRCode("qrcode",{
                        text: response,
                        width: 150,
                        height: 150,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'User Not Found!',
                    })
                }
                
            },
        });
    }
    
</script>
@endsection