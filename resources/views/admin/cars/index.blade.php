@extends('layouts.admin')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Cars</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Cars</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <div class="card w-75 text-center m-auto">
        <div class="card-body">
            <div class="row d-flex justify-content-between m-2 w-25">


                <!-- <button class="btn btn-outline-success" onclick="showForm(event, 'addCarDiv', 'store')">Add New Car</button> -->
                <button class="btn btn-outline-success" onclick="showForm(event, 'addCarDiv', 'cars', 'store', 'Add New', 'Save Car')">Add Car</button>

            </div>
            <!-- Add / Update Car -->
            <div class="modal" id="addCarDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        <span id="div-title"></span><span>&nbsp;Car</span>
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'addCarDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <form class="form" action="" method="post" id="addCarForm">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="car_number">Car Number:</label>
                                    <input type="text" class="form-control mb-2" id="car_number" name="car_number" value="{{old('car_number')}}" placeholder="Car Number">
                                </div>
                                <div class="col-sm-6">
                                    <label for="car_model">Car Model (Year):</label>
                                    <input type="text" class="form-control mb-2" id="car_model" name="car_model" value="{{old('car_model')}}" placeholder="Car Model">
                                </div>

                                <div class="col-sm-6">
                                    <label for="car_type">Car Name:</label>
                                    <input type="text" class="form-control mb-2" id="car_type" name="car_type" value="{{old('car_type')}}" placeholder="Car Type">

                                </div>
                                <div class="col-sm-6">
                                    <label for="seats">No. of Seats:</label>
                                    <input type="number" class="form-control mb-2" id="seats" name="seats" value="{{old('seats')}}" placeholder="No. of Seats">

                                </div>
                                <div class="col-sm-6">
                                    <label for="luggage_limit">Luggage Limit:</label>
                                    <input type="number" class="form-control mb-2" id="luggage_limit" name="luggage_limit" value="{{old('luggage_limit')}}" placeholder="Luggage Limit">

                                </div>
                                <div class="col-sm-6">
                                    <label for="price_per_km">Price Per KM:</label>
                                    <input type="number" class="form-control mb-2" id="price_per_km" name="price_per_km" value="{{old('price_per_km')}}" placeholder="Price Per KM">

                                </div>
                                <div class="col-sm-6">
                                    <label for="price_per_hour">Price Per Hour:</label>
                                    <input type="number" class="form-control mb-2" id="price_per_hour" name="price_per_hour" value="{{old('price_per_hour')}}" placeholder="Price Per Hour">

                                </div>
                                <div class="col-sm-6">
                                    <label for="ac">AC Availability:</label>
                                    <select id="ac" name="ac" class="form-control">
                                        <option value="" selected>Select AC Availability ...</option>

                                        <option value="1">AC</option>
                                        <option value="0">Non-AC</option>

                                    </select>
                                </div>
                                @php
                                $tripTypes = \App\Models\TripType::all();
                                @endphp

                                <div class="col-sm-6">
                                    <label for="trip_type_ids_display">Trip Types:</label>

                                    <!-- Display selected values -->
                                    <div class="dropdown" id="tripTypeDropdown">
                                        <input type="text" id="trip_type_ids_display" class="form-control" placeholder="Select Trip Types" readonly onclick="toggleDropdown()" />
                                        <div id="dropdownOptions" class="dropdown-menu w-100 p-2 border" style="display: none; max-height: 200px; overflow-y: auto;">
                                            @foreach ($tripTypes as $type)
                                            <label class="d-block">
                                                <input type="checkbox" value="{{ $type->id }}" onchange="updateSelectedTripTypes()" />
                                                {{ $type->name }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Actual input to be sent to server -->
                                    <input type="hidden" name="trip_type_ids[]" id="trip_type_ids_hidden" />
                                </div>


                                <div class="col-sm-6">
                                    <label for="car_image">Car Image:</label>
                                    <input type="file" accept="image/*" class="form-control mb-2" id="car_image" name="car_image" placeholder="Car Image">
                                    <img id="carimage" src="" alt="Car1 Image" class="img-fluid rounded img_preview" style="max-height: 150px;">

                                </div>
                            </div>

                            <br>
                            <br>
                            <button type="button" name="submit" class="btn btn-outline-success" id="submitBtn" onclick="addCar(event)" name="addCarBtn">Save</button>
                        </form>


                    </div>
                </div>
            </div>


            <!-- View Car Modal -->
            <div class="modal" id="viewCarDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        View Car Details
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'viewCarDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Car Number</th>
                                        <td id="view_car_number"></td>
                                    </tr>
                                    <tr>
                                        <th>Car Model</th>
                                        <td id="view_car_model"></td>
                                    </tr>
                                    <tr>
                                        <th>Car Type</th>
                                        <td id="view_car_type"></td>
                                    </tr>
                                    <tr>
                                        <th>No. of Seats</th>
                                        <td id="view_seats"></td>
                                    </tr>
                                    <tr>
                                        <th>Luggage Limit</th>
                                        <td id="view_luggage_limit"></td>
                                    </tr>
                                    <tr>
                                        <th>Price Per KM</th>
                                        <td id="view_price_per_km"></td>
                                    </tr>
                                    <tr>
                                        <th>Price Per Hour</th>
                                        <td id="view_price_per_hour"></td>
                                    </tr>
                                    <tr>
                                        <th>AC Availability</th>
                                        <td id="view_ac"></td>
                                    </tr>
                                    <tr>
                                        <th>Trip Types</th>
                                        <td id="view_trip_types"></td>
                                    </tr>
                                    <tr>
                                        <th>Car Image</th>
                                        <td>
                                            <img id="view_car_image" src="" alt="Car Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>


            <div class="table-responsive">
                <table class="table carTable text-center table-hover  table-bordered" id="carTable">

                </table>
            </div>
        </div>
    </div>
</div>


@endsection