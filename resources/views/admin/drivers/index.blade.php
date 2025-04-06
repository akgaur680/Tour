@extends('layouts.admin')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Drivers Management</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Drivers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <div class="card w-75 text-center m-auto">
        <div class="card-body">
            <div class="row d-flex justify-content-between m-2 w-25">


                <!-- <button class="btn btn-outline-success" onclick="showForm(event, 'carsDiv', 'store')">Add New Car</button> -->
                <button class="btn btn-outline-success" onclick="showForm(event, 'driversDiv','drivers', 'store' )">Add Drivers</button>

            </div>
            <!-- Add / Update Car -->
            <div class="modal" id="driversDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        <span id="div-title"></span><span>&nbsp;Driver</span>
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'driversDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <form class="form" action="" method="post" id="driversForm" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="name">Name :</label>
                                    <input type="text" class="form-control mb-2" id="name" name="name" value="{{old('name')}}" placeholder="Driver's Name">
                                </div>
                                <div class="col-sm-6">
                                    <label for="email">Email ID :</label>

                                    <input type="email" class="form-control mb-2" id="email" name="email" value="{{old('email')}}" placeholder="Driver's Email">
                                </div>

                                <div class="col-sm-6">
                                    <label for="mobile_no">Contact Number :</label>

                                    <input type="number" class="form-control mb-2" id="mobile_no" name="mobile_no" value="{{old('mobile_no')}}" placeholder="Driver's Contact Number">

                                </div>
                                <div class="col-sm-6">
                                    <label for="mobile_no">Select Car :</label>
                                    @php
                                    $cars = \App\Models\Car::all();
                                    @endphp
                                    <select id="car_id" name="car_id" class="form-control mb-2">
                                        <option>Select Car</option>
                                        @foreach ($cars as $car )
                                        <option value="{{$car['id']}}">{{$car['car_type']}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-sm-6">
                                    <label for="driving_license">Driving License Number :</label>

                                    <input type="text" class="form-control mb-2" id="driving_license" name="driving_license" value="{{old('driving_license')}}" placeholder="Driving License Number">

                                </div>
                                <div class="col-sm-6">
                                    <label for="adhaar_number">Adhaar Card Number :</label>

                                    <input type="text" class="form-control mb-2" id="adhaar_number" name="adhaar_number" value="{{old('adhaar_number')}}" placeholder="Adhaar Card Number">

                                </div>

                                <div class="col-sm-6">
                                    <label for="dob">Date of Birth :</label>
                                    @php
                                    $maxDate = now()->subYears(18)->format('Y-m-d');
                                    @endphp
                                    <input type="date" class="form-control mb-2" id="dob" name="dob" max="{{ $maxDate }}" value="{{old('dob')}}" placeholder="Driver's Date of Birth">

                                </div>
                                <div class="col-sm-6">
                                    <label for="license_expiry">Driving License Expiry :</label>
                                    @php
                                    $todayDate = now()->format('Y-m-d');
                                    @endphp
                                    <input type="date" class="form-control mb-2" id="license_expiry" name="license_expiry" min="{{ $todayDate }}" value="{{old('license_expiry')}}" placeholder="Driving License Expiry Date">

                                </div>
                                <div class="col-sm-12">
                                    <label for="address">Address :</label>

                                    <textarea class="form-control mb-2" id="address" name="address" placeholder="Driver's Address" rows="2" cols="4">{{old('address')}}</textarea>

                                </div>
                                <!-- Profile Image -->
                                <div class="col-sm-6">
                                    <label for="profile_image">Profile Image :</label>
                                    <input type="file" accept="image/*" class="form-control mb-2" id="profile_image" name="profile_image">
                                    <img id="profile_image_preview" src="" alt="Profile Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
                                </div>

                                <!-- Driving License Image -->
                                <div class="col-sm-6">
                                    <label for="license_image">Driving License Image :</label>
                                    <input type="file" accept="image/*" class="form-control mb-2" id="license_image" name="license_image">
                                    <img id="license_image_preview" src="" alt="Driver's License Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
                                </div>

                                <!-- Aadhaar Front -->
                                <div class="col-sm-6">
                                    <label for="adhaar_image_front">Aadhaar Card Front Image :</label>
                                    <input type="file" accept="image/*" class="form-control mb-2" id="adhaar_image_front" name="adhaar_image_front">
                                    <img id="adhaar_image_front_preview" src="" alt="Aadhaar Card Front Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
                                </div>

                                <!-- Aadhaar Back -->
                                <div class="col-sm-6">
                                    <label for="adhaar_image_back">Aadhaar Card Back Image :</label>
                                    <input type="file" accept="image/*" class="form-control mb-2" id="adhaar_image_back" name="adhaar_image_back">
                                    <img id="adhaar_image_back_preview" src="" alt="Aadhaar Card Back Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
                                </div>
                            </div>

                            <br>
                            <br>
                            <button type="button" name="submit" class="btn btn-outline-success" id="submitBtn" onclick="addDriver(event)" name="addDriverBtn">Save</button>
                        </form>


                    </div>
                </div>
            </div>


            <!-- View Driver Modal -->
            <div class="modal" id="viewDriverDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        View Driver Details
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'viewDriverDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td id="view_name"></td>
                </tr>
                <tr>
                    <th>Email ID</th>
                    <td id="view_email"></td>
                </tr>
                <tr>
                    <th>Contact Number</th>
                    <td id="view_mobile_no"></td>
                </tr>
                <tr>
                    <th>View Car Details</th>
                    <td id="view_car"></td>
                </tr>
                <tr>
                    <th>Driving License</th>
                    <td id="view_driving_license"></td>
                </tr>
                <tr>
                    <th>Aadhaar Number</th>
                    <td id="view_adhaar_number"></td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td id="view_dob"></td>
                </tr>
                <tr>
                    <th>Driving License Expiry</th>
                    <td id="view_license_expiry"></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td id="view_address"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row text-center">
        <div class="col-md-6 mb-3">
            <label class="fw-bold">Profile Image:</label>
            <div>
                <img id="view_profile_image" src="" alt="Profile Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="fw-bold">Driving License Image:</label>
            <div>
                <img id="view_driving_license_image" src="" alt="Driving License Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="fw-bold">Aadhaar Card Front Image:</label>
            <div>
                <img id="view_adhaar_front_image" src="" alt="Aadhaar Card Front Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <label class="fw-bold">Aadhaar Card Back Image:</label>
            <div>
                <img id="view_adhaar_back_image" src="" alt="Aadhaar Card Back Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
            </div>
        </div>
    </div>
</div>

                </div>
            </div>


           <div class="table-responsive">
           <table class="table driverTable text-center table-hover  table-bordered" id="driverTable">
              
              </table>
           </div>
        </div>
    </div>
</div>


@endsection