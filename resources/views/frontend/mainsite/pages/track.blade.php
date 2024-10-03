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

    .form-control-input {
        margin-bottom: 15px;
    }

    .alert {
        padding: 2px;
        margin-bottom: 50px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }

    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .form-control {
        height: 2.5rem;
        font-size: 1rem;
    }

    .custom_label {
        font-weight: bold;
        margin-top: 10px;
    }

</style>

<div class="container-fluid py-1">
    <div class="container py-5">
        <div class="row g-5 align-items-start" style="background-color: ghostwhite;">
            
            <!-- Sidebar Section (30% width) -->
            @include('frontend.layout.dashboardsidebar')

            <!-- Main Content Section (70% width) -->
            <div class="col-lg-8 fadeInLeft" data-wow-delay="0.1s">
                <h2 class="display-10 mb-2">Track</h2>

                @if(empty($currentPlanName))
                    <div class="alert alert-danger" role="alert">
                        In order to start tracking, you must <a href="{{url('/')}}#plans"><b>SIGN UP FOR A PLAN</b></a>.
                    </div>
                    <br>
                @endif

                <div class="cmn-form">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('no_plan_error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('no_plan_error') }}
                        </div>
                    @endif

                    @if(session('plan_error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('plan_error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success" style="color: green;font-size: 18px;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form name="save_track" method="post" action="{{route('track.save')}}">
                        @csrf
                        
                        <div class="form-control-input">
                            <label class="custom_label">ALERT ME WHEN:</label>
                            <label for="store">STORE:</label>
                            <select name="store" id="store" class="l-store form-control">
                                <option value="" disabled selected>Loading Stores...</option>
                            </select>
                        </div>

                        <div class="form-control-input">
                            <label for="discount_type">DISCOUNT TYPE:</label>
                            <select class="form-control" id="discount_type" name="discount_type">
                                <option value="">--Select--</option>
                                <option value="Percentage">Percent Cash Back</option>
                                <option value="Fixed">Fixed Cash Back</option>
                            </select>
                        </div>

                        IS EQUAL TO/GREATER THAN:
                        <div class="form-control-input">
                            <label for="price">AMOUNT:</label>
                            <input type="text" class="form-control" placeholder="Enter Amount" id="price" name="price">
                        </div>

                        <div class="form-control-atype">
                            <label>ALERT TYPE:</label>
                            <div class="box-container">
                                <input type="radio" value="email" name="alert_type" class="form-check-input" checked>
                                <label>Email</label>
                            </div>
                            <div class="box-container">
                                <input type="radio" name="alert_type" value="text" class="form-check-input">
                                <label>Text/SMS*</label>
                            </div>
                            <div class="box-container">
                                <input type="radio" name="alert_type" value="both" class="form-check-input">
                                <label>Both</label>
                            </div>
                        </div>

                        <div class="form-control-add">
                            <input type="submit" id="submit" class="btn btn-primary w-100 py-3" value="Submit">
                        </div>
                    </form>

                    @if(count($all_tracks) > 0)
                        <div class="table-responsive mt-4">
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Store Name</th>
                                        <th scope="col">Discount Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Alert Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($all_tracks as $key => $track)
                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $track->store_name }}</td>
                                        <td>{{ $track->discount_type == 'Fixed' ? 'Cash back' : 'Percentage' }}</td>
                                        <td>${{ number_format($track->price, 2) }}</td>
                                        <td>
                                            @if ($track->alert_email && $track->alert_text)
                                                <span class="badge bg-success">Both</span>
                                            @elseif ($track->alert_email)
                                                <span class="badge bg-primary">Email</span>
                                            @elseif ($track->alert_text)
                                                <span class="badge bg-warning">Text/SMS</span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('editalert', $track->id) }}" class="btn btn-sm btn-primary" title="Edit Track">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ url('track/remove') }}/{{ $track->id }}" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger" title="Delete Track">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
                } else {
                    alert('Request failed. Please try again later.');
                }
            };
            xhr.send();
        }
    });
</script>

@endsection
