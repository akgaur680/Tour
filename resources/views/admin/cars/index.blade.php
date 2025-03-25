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


                <button class="btn btn-outline-success" onclick="showForm(event, 'addCarDiv', 'store')">Add New Car</button>
            </div>
            <div class="modal" id="addCarDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">Add a Car
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'addCarDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <form class="form" action="" method="post" id="addCarForm">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <input type="text" class="form-control mb-2" id="car_number" name="car_number" value="{{old('car_number')}}" placeholder="Car Number">
                                </div>
                                <div class="col-sm-6">

                                    <input type="text" class="form-control mb-2" id="car_model" name="car_model" value="{{old('car_model')}}" placeholder="Car Model">
                                </div>

                                <div class="col-sm-6">
                                    <input type="text" class="form-control mb-2" id="car_type" name="car_type" value="{{old('car_type')}}" placeholder="Car Type">

                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control mb-2" id="seats" name="seats" value="{{old('seats')}}" placeholder="No. of Seats">

                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control mb-2" id="luggage_limit" name="luggage_limit" value="{{old('luggage_limit')}}" placeholder="Luggage Limit">

                                </div>
                                <div class="col-sm-6">
                                    <input type="number" class="form-control mb-2" id="price_per_km" name="price_per_km" value="{{old('price_per_km')}}" placeholder="Price Per KM">

                                </div>
                                <div class="col-sm-6">
                                    <select id="ac" name="ac" class="form-control">
                                        <option value="" selected>Select AC Availability ...</option>

                                        <option value="1">AC</option>
                                        <option value="0">Non-AC</option>

                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <input type="file" class="form-control mb-2" id="car_image" name="car_image" value="{{old('car_image')}}" placeholder="Car Image">

                                </div>
                            </div>

                            <br>
                            <br>
                            <br>
                            <br>
                            <button type="button" name="submit" class="btn btn-outline-success" id="addCarBtn" onclick="addCar(event)" name="addCarBtn">Save</button>
                        </form>


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