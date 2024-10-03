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
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 4px;
        font-size: 14px;
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
                <h2 class="display-10 mb-2">Edit Alert</h2>

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

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form name="save_track" method="post" action="{{route('track.update', $alert->id)}}">
                    @csrf

                    <input type="hidden" value="{{$alert->store_id}}" id="current_store_id" name="current_store_id">

                    <div class="form-control-input">
                        <label class="custom_label">STORE:</label>
                        <select name="store" id="store" class="form-control">
                            <option value="" disabled selected>Loading Stores...</option>
                        </select>
                    </div>

                    <div class="form-control-input">
                        <label class="custom_label">DISCOUNT TYPE:</label>
                        <select class="form-control" id="discount_type" name="discount_type">
                            <option value="">--Select--</option>
                            <option value="Percentage" {{ $alert->discount_type == 'Percentage' ? 'selected' : '' }}>Percent Cash Back</option>
                            <option value="Fixed" {{ $alert->discount_type == 'Fixed' ? 'selected' : '' }}>Fixed Cash Back</option>
                        </select>
                    </div>

                    IS EQUAL TO/GREATER THAN:
                    <div class="form-control-input">
                        <label class="custom_label">AMOUNT:</label>
                        <input type="text" class="form-control" value="{{$alert->price}}" placeholder="Enter Amount" id="price" name="price" oninput="this.value = this.value.replace(/[^\d.]/g, '').replace(/^(\d{0,3})(\.\d{0,2})?.*$/, '$1$2');">
                    </div>

                    <div class="form-control-atype">
                        <label class="custom_label">ALERT TYPE:</label>
                        <div class="form-check">
                            <input type="radio" value="email" name="alert_type" class="form-check-input" {{ $alert->alert_email == 'email' && $alert->alert_text != 'text' ? 'checked' : '' }}>
                            <label class="form-check-label">Email</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" value="text" name="alert_type" class="form-check-input" {{ $alert->alert_text == 'text' && $alert->alert_email != 'email' ? 'checked' : '' }}>
                            <label class="form-check-label">Text/SMS*</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" value="both" name="alert_type" class="form-check-input" {{ $alert->alert_email == 'email' && $alert->alert_text == 'text' ? 'checked' : '' }}>
                            <label class="form-check-label">Both</label>
                        </div>
                        <span class="footer_note"><i>Note: Message and data rates may apply. Message frequency may vary. To opt out, please reply with "STOP"..</i></span>
                    </div>

                    <div class="form-control-add mt-3">
                        <input type="submit" class="btn btn-primary w-100 py-2" value="Update">
                    </div>
                </form>

                @if(count($all_tracks) > 0)
                    <div class="table-responsive mt-4">
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Store Name</th>
                                    <th>Operator</th>
                                    <th>Discount Type</th>
                                    <th>Amount</th>
                                    <th>Alert Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($all_tracks as $key=>$track)
                                    <tr>
                                        <th scope="row">{{ $key+1 }}</th>
                                        <td>{{ $track->store_name }}</td>
                                        <td>{{ $track->operator == '>' ? 'Greater than' : ($track->operator == '==' ? 'Equal to' : '') }}</td>
                                        <td>{{ $track->discount_type == 'Fixed' ? 'Cash back' : 'Percentage' }}</td>
                                        <td>{{ $track->price }}</td>
                                        <td>{{ ucfirst($track->alert_type) }}</td>
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

    setTimeout(() => {
        $('#store').val($('#current_store_id').val()).trigger('change');
    }, 1000);
</script>

@endsection
