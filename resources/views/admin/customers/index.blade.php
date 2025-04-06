@extends('layouts.admin')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Customers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <div class="card w-75 text-center m-auto">
        <div class="card-body">


            <!-- View Pricing Modal -->
            <div class="modal" id="viewCustomerDiv" style="display: none;">
                <div class="card modal-content">
                    <h2 class="card-title mt-2" id="card-title">
                        View Customer
                        <button type="button" class="close m-3" aria-label="Close" onclick="closeDiv(event, 'viewCustomerDiv')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </h2>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td id="view_name"></td>
                                    </tr>
                                    <tr>
                                        <th>Email Id</th>
                                        <td id="view_email"></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile Number</th>
                                        <td id="view_mobile_no"></td>
                                    </tr>
                                    <tr>
                                        <th>Date of Birth</th>
                                        <td id="view_dob"></td>
                                    </tr>
                                    <tr>
                                        <th>Joined On</th>
                                        <td id="view_joined_on"></td>
                                    </tr>
                                    <tr id="addressRow" style="display: none;">
                                        <th>Address</th>
                                        <td id="view_address"></td>
                                    </tr>
                                    <tr>
                                        <th>Profile Image</th>
                                        <td>
                                            <img id="view_profile_image" src="" alt="Profile Image" class="img-fluid rounded img_preview" style="max-height: 150px; margin: auto;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <div class="table-responsive">

                <table class="table customerTable text-center table-hover  table-bordered" id="customerTable">

                </table>
            </div>
        </div>
    </div>
</div>


@endsection