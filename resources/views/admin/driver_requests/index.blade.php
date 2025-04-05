@extends('layouts.admin')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Driver Requests</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Driver Requests</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <div class="card w-75 text-center m-auto">
        <div class="card-body">

            <!-- View Transaction Modal -->
            <div class="modal" id="viewDriverRequestDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        View Driver Details
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'viewDriverRequestDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>Driver's Name</th>
                                    <td id="view_name"></td>
                                </tr>
                                <tr>
                                    <th>Driver's Email ID</th>
                                    <td id="view_email"></td>
                                </tr>
                                <tr>
                                    <th>Driver's Contact Number</th>
                                    <td id="view_mobile_no"></td>
                                </tr>
                                <tr>
                                    <th>Driver's Car</th>
                                    <td id="view_car"></td>
                                </tr>
                                <tr>
                                    <th>Driving Licence</th>
                                    <td id="view_license"></td>
                                </tr>
                                <tr>
                                    <th>Adhaar Card</th>
                                    <td id="view_adhaar"></td>
                                </tr>
                                <tr>
                                    <th>Driving Licence Expiry</th>
                                    <td id="view_license_expiry"></td>
                                </tr>
                                <tr>
                                    <th>Profile Image</th>
                                    <td><img id="view_profile_image" class="img-fluid rounded img_preview" style="max-height: 150px;" /></td>
                                </tr>
                                <tr>
                                    <th>Driving Licence Image</th>
                                    <td><img id="view_license_image" class="img-fluid rounded img_preview" style="max-height: 150px;" /></td>
                                </tr>
                                <tr>
                                    <th>Adhaar Card Front Image</th>
                                    <td><img id="view_adhaar_front" class="img-fluid rounded img_preview" style="max-height: 150px;" /></td>
                                </tr>
                                <tr>
                                    <th>Adhaar Card Back Image</th>
                                    <td><img id="view_adhaar_back" class="img-fluid rounded img_preview" style="max-height: 150px;" /></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4">
    <div class="row">
        <div class="col-md-6">
            <label for="approval_status" class="form-label fw-bold">Approval Status</label>
            <select id="approval_status" class="form-select">
                <option value="">-- Select Status --</option>
                <option value="1">Approve</option>
                <option value="0">Reject</option>
            </select>
        </div>
        <div class="col-md-6 d-flex align-items-end">
            <button type="button" id="updateStatusBtn" class="btn btn-success" >Submit</button>
        </div>
    </div>
</div>

                    </div>

                </div>
            </div>

            <!-- Verify Payment Modal -->
            <div class="modal" id="driverRequestDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        Approve /Reject Driver
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'driverRequestDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <form id="vprroveRequestForm">
                            <input type="hidden" id="payment_order_id" name="order_id">

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Received Amount</th>
                                        <td id="verify_received_amount" class="align-middle"></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Proof</th>
                                        <td>
                                            <img id="verify_payment_proof_img" class="img-fluid rounded" style="max-height: 200px;" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mb-3">
                                <label for="verify_action" class="fw-bold">Verification Status:</label>
                                <select class="form-control" id="verify_action" name="verify_action" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="approve">Approve</option>
                                    <option value="reject">Reject</option>
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-success" onclick="submitVerification()">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="">
                <table class="table driverRequestTable text-center table-hover table-bordered" id="driverRequestTable">
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