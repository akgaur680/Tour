@extends('layouts.admin')

@section('content')



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bookings</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Bookings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->


    <div class="card w-75 text-center m-auto">
        <div class="card-body">
          
            <table class="table bookingTable text-center table-hover  table-bordered" id="bookingTable">
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


@endsection