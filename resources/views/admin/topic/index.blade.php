@extends('layouts.adminlayout')
@section('AdminActiveButton')
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{URL::to('/admin/dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Managements</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Components:</h6>
                        <a class="collapse-item" href="{{URL::to('/admin/category')}}">Category</a>
                        <a class="collapse-item" href="{{URL::to('/admin/topic')}}">Topic</a>
                        <a class="collapse-item" href="{{URL::to('/admin/idea')}}">Idea</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Users</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Components:</h6>
                        <a class="collapse-item" href="utilities-color.html">Administrator</a>
                        <a class="collapse-item" href="utilities-border.html">Staff</a>
                    </div>
                </div>
            </li>
@endsection

@section('AdminContent')

	<div class="col-md-12 text-center"><h3><strong>Topic</strong></h3></div>
    <div class="col-md-12 mb-3">
        <a href="#" class="btn btn-success"><i class="fas fa-plus"></i> Create New</a>
    </div>
        <div class="col-md-12">
            <table class="table">
        <thead class="table-dark">
            <th>#</th>
            <th>Topic Name</th>
            <th>Image</th>
            <th>Create Date</th>
            <th>Update Date</th>
            <th>Action</th>
        </thead>
        <tbody>
            <td>1</td>
            <td>Improvement</td>
            <td><img src="#" alt="Picture Not Found!"></td>
            <td>2022/02/07</td>
            <td>2022/02/08</td>
            <td>
                <a href="#" class="btn btn-info"><i class="fas fa-edit"></i></a>
                
                <a href="#" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                
                <a href="#" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                
            </td>
        </tbody>
        <tfoot>
            <th>#</th>
            <th>Category Name</th>
            <th>Image</th>
            <th>Create Date</th>
            <th>Update Date</th>
            <th>Action</th>
        </tfoot>
    </table>
    </div>

@endsection