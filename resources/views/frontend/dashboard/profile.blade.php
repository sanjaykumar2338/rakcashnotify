@extends('frontend.mainsite.layouts.dashboard')
@section('content')

<style>
    .sidebar {
        width: 250px;
        min-width: 150px;
        max-width: 400px;
        top: 0;
        left: 0;
        background-color: #333;
        color: #fff;
        padding-top: 20px;
        overflow-y: auto;
        transition: width 0.3s ease;
        padding-inline: 8px;
        height: 70vh;
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar ul li {
        padding: 20px;
        border-bottom: 1px solid #555;
    }

    .sidebar ul li a {
        color: #fff;
        text-decoration: none;
    }

    .sidebar ul li a:hover {
        background-color: #555;
    }


</style>
<div class="container-fluid py-1">
    <div class="container py-5">
        <div class="row g-5 align-items-start" style="background-color: ghostwhite;">
            
            <!-- Sidebar Section (30% width) -->
            @include('frontend.layout.dashboardsidebar')

            <!-- Profile Update Form Section (70% width) -->
            <div class="col-lg-8  fadeInLeft" data-wow-delay="0.1s">
                @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" role="alert" style="">
                        {{ session('error') }}
                    </div><br>
                @endif

                @if(session('success'))
                    <div class="alert alert-success" style="color: green;font-size: 18px;">
                        {{ session('success') }}
                    </div><br>
                @endif
                
                <h2 class="display-10 mb-2">Profile</h2>
                <form name="profile_update" method="post" action="{{route('profile.update')}}">
                    @csrf
                    
                    <div class="row g-2">
                        <div class="form-control-input">
                            <label>First Name:</label>
                            <input type="text" class="l-operator form-control" placeholder="Enter First Name" id="first_name" name="first_name" value="{{auth()->user()->first_name}}">
                        </div>

                        <div class="form-control-input">
                            <label>Last Name:</label>
                            <input type="text" class="l-operator form-control" placeholder="Enter Last Name" id="last_name" name="last_name" value="{{auth()->user()->last_name}}">
                        </div>

                        <div class="form-control-input">
                            <label>Email:</label>
                            <input type="text" class="l-operator form-control" placeholder="Enter Email" id="email" name="email" value="{{auth()->user()->email}}">
                        </div>

                        <div class="form-control-input">
                            <label>Phone:</label>
                            <input type="text" class="l-operator form-control" placeholder="Enter Phone Number" id="phone_number" name="phone_number" value="{{auth()->user()->phone_number}}">
                        </div>

                        <div class="form-control-input">
                            <label>New Password:</label>
                            <input autocomplete="new-password" type="password" class="l-operator form-control" placeholder="Enter new password" id="password" name="password" value="">
                        </div>

                        <div class="form-control-input">
                            <label>Conf. Password:</label>
                            <input autocomplete="new-password" type="password" class="l-operator form-control" placeholder="Confirm new password" id="password_confirmation" name="password_confirmation" value="">
                        </div>

                        <div class="form-control-add">
                            <input type="submit" id="submit" class="btn btn-primary w-100 py-3"  value="Update">
                        </div>
                    </div>
                </form>                   
            </div>
        </div>
    </div>
</div>

<script>
    if(document.getElementById('store')){
        document.getElementById('store').addEventListener('change', function() {
            var storeId = this.value;
            if (storeId) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/check_store/' + storeId, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if(!response.exist){
                            alert(response.message);
                        }
                        // You can further handle the response here
                    } else {
                        alert('Request failed. Please try again later.');
                    }
                };
                xhr.send();
            }
        }); 
    }
</script>
@endsection
