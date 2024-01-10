<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <title>Blog</title>
    <style>
        .help-text{
            color:red;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card shadow">
                    <div class="card-header bg-danger text-white">
                        <div class="card-title">
                            <span>Add User</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" id="form" name="user-form" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Phone <span class="text-danger">*</span></label>
                                <input type="number" name="phone" id="phone" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name">Country <span class="text-danger">*</span></label>
                                <select name="country" id="country" class="get-countries basic-select2 form-control">
                                    <option value="">Please Select</option>
                                    @if(count($countries))
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">State <span class="text-danger">*</span></label>
                                <select name="state" id="state" class="basic-select2 form-control" disabled>
                                    <option value="">Please Select</option>
                                    @if(count($states))
                                    @foreach($states as $state)
                                        <option value="{{$state->state_id}}">{{$state->state_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">City <span class="text-danger">*</span></label>
                                <select name="city" id="city" class="basic-select2 form-control" disabled>
                                    <option value="">Please Select</option>
                                    @if(count($cities))
                                    @foreach($cities as $city)
                                        <option value="{{$city->city_id}}">{{$city->city_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="name">Profile Image</label>
                                <input type="file" class="form-control" name="profile_image" accept="image/*">
                            </div>
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-danger" type="submit">Button</button>
                              </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @isset($validator)
        {!! $validator!!}
    @endisset
    <script>
        $(document).ready(function(){
            $('.basic-select2').select2({
                allowClear:true,
                placeholder: 'Please Select'
            })

            $('#country').on('change',function(e){
                $('#state').prop('disabled',false);
            })

            $('#state').on('change',function(){
                $('#city').prop('disabled',false);
            })

           $('#form').on('submit',function(e){
                e.preventDefault();

               

                $.ajax({
                    type:'POST',
                    url:"{{route('users.store')}}",
                    data:new FormData(this),
                    async: false,
                    dataType:'json',
                    cache: false, processData: false,
                    contentType: false,
                    headers: {
                        "Accept": "application/json"
                    },
                    success:function(res){
                        Toastify({
                            text: res.message,
                            className: "success",
                        }).showToast();
                       
                    },
                    error:function(error){
                        Toastify({
                            text: res.message,
                            className: "error",
                        }).showToast();
                    },
                    complete:function(){
                        resetForm();
                    }
                })
           })
        })

        function resetForm(){
            $('#form')[0].reset();
            $('#country').val('').trigger('change');
            $('#state').val('').trigger('change');
            $('#city').val('').trigger('change');
            $('#state').prop('disabled',true)
            $('#city').prop('disabled',true)
        }
    </script>
</body>
</html>