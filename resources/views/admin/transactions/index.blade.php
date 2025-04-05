@extends('layouts.admin')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Trasactions</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Transactions</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <div class="card  text-center m-auto">
        <div class="card-body">

<!-- View Transaction Modal -->
<div class="modal" id="viewTransactionDiv" style="display: none;">
    <div class="card modal-content">
        <h2 class="card-title mt-2" id="card-title">
            View Transaction Details
            <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'viewTransactionDiv')">
                <span aria-hidden="true">&times;</span>
            </button>
        </h2>

        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr><th>Name</th><td id="view_name"></td></tr>
                    <tr><th>Email ID</th><td id="view_email"></td></tr>
                    <tr><th>Contact Number</th><td id="view_mobile_no"></td></tr>
                    <tr><th>Car</th><td id="view_car"></td></tr>
                    <tr><th>Pickup Location</th><td id="view_pickup_location"></td></tr>
                    <tr><th>Drop Location</th><td id="view_drop_location"></td></tr>
                    <tr><th>Pickup Date</th><td id="view_pickup_date"></td></tr>
                    <tr><th>Pickup Time</th><td id="view_pickup_time"></td></tr>
                    <tr><th>Booking Status</th><td id="view_booking_status"></td></tr>
                    <tr><th>Payment Status</th><td id="view_payment_status"></td></tr>
                    <tr><th>Received Amount</th><td id="view_received_amount"></td></tr>
                    <tr><th>Total Amount</th><td id="view_total_amount"></td></tr>
                    <tr><th>Booking Token</th><td id="view_booking_token"></td></tr>
                </tbody>
            </table>

            <div class="row text-center">
                <div class="col-md-3">
                    <label class="fw-bold">Payment Proof</label>
                    <img id="view_payment_proof" class="img-fluid rounded img_preview" style="max-height: 150px;" />
                </div>
             
            </div>
        </div>
    </div>
</div>
          
        <div class="table-responsive">
        <table class="table transactionTable text-center table-hover table-responsive table-bordered" id="transactionTable">
                <!-- <thead class="text-center">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Car</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead> -->


            </table>
        </div>
        </div>
    </div>
</div>


@endsection