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
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                                    <label for="car_model">Car Model:</label>
                                    <input type="text" class="form-control mb-2" id="car_model" name="car_model" value="{{old('car_model')}}" placeholder="Car Model">
                                </div>

                                <div class="col-sm-6">
                                    <label for="car_type">Car Type:</label>
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
                                    <label for="ac">AC Availability:</label>
                                    <select id="ac" name="ac" class="form-control">
                                        <option value="" selected>Select AC Availability ...</option>

                                        <option value="1">AC</option>
                                        <option value="0">Non-AC</option>

                                    </select>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="fw-bold">Car Number:</label>
                                <p id="view_car_number"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Car Model:</label>
                                <p id="view_car_model"></p>
                            </div>

                            <div class="col-sm-6">
                                <label class="fw-bold">Car Type:</label>
                                <p id="view_car_type"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">No. of Seats:</label>
                                <p id="view_seats"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Luggage Limit:</label>
                                <p id="view_luggage_limit"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Price Per KM:</label>
                                <p id="view_price_per_km"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">AC Availability:</label>
                                <p id="view_ac"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Car Image:</label>
                                <div>
                                    <img id="view_car_image" src="" alt="Car Image" class="img-fluid rounded img_preview" style="max-height: 150px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <table class="table carTable text-center table-hover  table-bordered" id="carTable">
                <thead class="text-center">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Image</th>
                        <th>Car Number</th>
                        <th>Car Model</th>
                        <th>Car Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>


            </table>
        </div>
    </div>
</div>


@endsection