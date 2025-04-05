@extends('layouts.admin')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Fixed Pricing</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Tour Fixed Pricing</li>
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
                <button class="btn btn-outline-success" id="addPricingModalBtn" onclick="showForm(event, 'pricingDiv', 'Pricing', 'store', 'Add New Tour', 'Save Pricing')">Add Pricing</button>

            </div>
            <!-- Add / Update Pricing -->
            <div class="modal" id="pricingDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        <span id="div-title"></span><span>&nbsp;Pricing</span>
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'pricingDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <form class="form" action="" method="post" id="pricingForm">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div>
                                <h5>Select Trip Type :</h5>
                                <div class="">
                                    <div class="m-2">
                                        <label for="one-way">One-Way</label>
                                        <input type="radio" name="trip_type" class="form-radio-input" id="one-way" value="1" checked>
                                    </div>

                                    <label for="airport">Airport</label>
                                    <input type="radio" name="trip_type" id="airport" value="4">
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <label>Car Type :</label>
                                <select name="car_type" id="car_type" class="form-control">Car Type :
                                    <option selected> Select Car</option>
                                    @php
                                    $cars = \App\Models\Car::all();
                                    @endphp
                                    @foreach ($cars as $car )
                                    <option value="{{$car->id}}">{{$car->car_type}}</option>
                                    @endforeach
                                    @endphp
                                </select>

                            </div>
                            <div class="col-sm-6" id="airportTypeDiv">
                                <h5>Select Destination Type :</h5>
                                <div class="">
                                    <div class="m-2">
                                        <label for="from_airport">PickUp From Airport</label>
                                        <input type="radio" name="airport_type" class="form-radio-input" id="from_airport" value="from_airport" checked>
                                    </div>

                                    <label for="to_airport">Drop to Airtport</label>
                                    <input type="radio" name="airport_type" id="to_airport" value="to_airport">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="origin">Origin :</label>
                                    <input type="text" class="form-control mb-2" id="origin" name="origin" value="{{old('origin')}}" placeholder="Origin">
                                    <div id="originDropdown" class="dropdown-menu show" style="display: none; position: absolute; width: 100%; max-height: 200px; overflow-y: auto; z-index: 1000;"></div>

                                </div>
                                <div class="col-sm-6">
                                    <label for="destination">Destination :</label>
                                    <input type="text" class="form-control mb-2" id="destination" name="destination" value="{{old('destination')}}" placeholder="Destination">
                                    <div id="destinationDropdown" class="dropdown-menu show" style="display: none; position: absolute; width: 100%; max-height: 200px; overflow-y: auto; z-index: 1000;"></div>

                                </div>
                                <div class="col-sm-6">
                                    <label for="airport_name">Airport :</label>
                                    <input type="text" class="form-control mb-2" id="airport_name" name="airport_name" value="{{old('airport_name')}}" placeholder="Search Airport">
                                    <div id="airportDropdown" class="dropdown-menu show" style="display: none; position: absolute; width: 100%; max-height: 200px; overflow-y: auto; z-index: 1000;"></div>

                                </div>
                                <div class="col-sm-6">
                                    <label for="price">Price:</label>
                                    <input type="number" class="form-control mb-2" id="price" name="price" value="{{old('price')}}" placeholder="Price">
                                </div>

                            </div>

                            <br>
                            <br>
                            <button type="button" name="submit" class="btn btn-outline-success" id="submitBtn" onclick="addPricing(event)" name="addPricingBtn">Save</button>
                        </form>


                    </div>
                </div>
            </div>


            <!-- View Pricing Modal -->
            <div class="modal" id="viewPricingDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        View Pricing
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'viewPricingDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="fw-bold">Trip Type:</label>
                                <p id="view_trip_type"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Fixed Price:</label>
                                <p id="view_price"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Origin :</label>
                                <p id="view_origin"></p>
                            </div>

                            <div class="col-sm-6">
                                <label class="fw-bold">Destination:</label>
                                <p id="view_destination"></p>
                            </div>
                            

                        </div>
                        <hr>
                        <div class="row">
                            <h5 class="text-center">Car Details</h5>
                            <div class="col-sm-6">
                                <label class="fw-bold">Car Name:</label>
                                <p id="view_car_name"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Car Number:</label>
                                <p id="view_car_number"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Price per KM:</label>
                                <p id="view_price_per_km"></p>
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


          <div class="table-responsive">
          <table class="table pricingTable text-center table-hover  table-bordered" id="pricingTable">

</table>
          </div>
        </div>
    </div>
</div>


@endsection