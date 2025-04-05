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
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="fw-bold">Name :</label>
                                <p id="view_name"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Email Id:</label>
                                <p id="view_email"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Mobile Number :</label>
                                <p id="view_mobile_no"></p>
                            </div>

                            <div class="col-sm-6">
                                <label class="fw-bold">Date of Birth:</label>
                                <p id="view_dob"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Joined On:</label>
                                <p id="view_joined_on"></p>
                            </div>
                            <div class="col-sm-6" id="addressDiv" style="display: none;">
                                <label class="fw-bold">Address:</label>
                                <p id="view_address"></p>
                            </div>
                            <div class="col-sm-6">
                                <label class="fw-bold">Profile Image:</label>
                                <div>
                                    <img id="view_profile_image" src="" alt="Profile Image" class="img-fluid rounded img_preview" style="max-height: 150px; margin:auto">
                                </div>

                            </div>
                           

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