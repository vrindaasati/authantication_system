@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Profile') }}</div>
                <div class="card-body">
                    <form  id="editUser" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('First Name') }}</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control" name="first_name" id="first_name" value="{{ !empty($user->first_name) ? $user->first_name : ''  }}"  autocomplete="name" autofocus>
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Last Name') }}</label>

                            <div class="col-md-6">
                                <input  type="text" class="form-control" name="last_name" value="{{ !empty($user->last_name) ? $user->last_name : ''  }}" id="last_name" autocomplete="name" autofocus>
                                
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Profile Picture') }}</label>

                            <div class="col-md-4">
                                <input  type="file" class="form-control" name="profile_pic" id="profile_pic" accept="image/png, image/gif, image/jpeg"><br>
                                @if(!empty($user->profile_pic))
                                <img src="{{$user->profile_pic}}" alt="" width="50" hieght="50">
                                @endif
                            </div>
                        </div>
                        
                        
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ !empty($user->email) ? $user->email : ''  }}"  autocomplete="email" readonly></div>
                            </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="button" class="btn btn-primary" onclick="editUser()">
                                    {{ __('Update Profile') }}
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
        $("#editUser").validate({
            rules: {
                first_name: "required",
                email:{
                    required:true,
                    email:true,
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

    function editUser() {
        var isValid = $("#editUser").valid();
        if (!isValid) {
            return false;
        }

        var formData = new FormData();
        $('#editUser :input').each(function() {
            var element = $(this);
            var fieldName = element.attr('name');
            var fieldType = element.attr('type');
            if (fieldType === 'file') {
                var file = element[0].files[0];
                formData.append(fieldName, file);
            } else {
                var fieldValue = element.val();
                formData.append(fieldName, fieldValue);
            }
        });
        $.ajax({
            method: 'POST',
            url: "{{ route('update_profile') }}",
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                if(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Hurray...',
                        text: 'Data updated successfully!',
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
            }
            
        });
    }
</script>
@endsection