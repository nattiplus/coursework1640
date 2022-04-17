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
	<div class="col-md-12 text-center"><h3><strong>Idea</strong></h3></div>
    <div class="col-md-12">
    <table class="table">
        <thead class="table-dark">
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Content</th>
            <th>User</th>
            <th>Category</th>
            <th>Submission</th>
            <th>Create Date</th>
            <th>Modify Date</th>
            <th>Action</th>
        </thead>
        <?php
            $ideas = App\Models\Idea::all();
            foreach($ideas as $idea){ ?>
        <tbody>
            <td>{{ $idea->id }}</td>
            <td>{{ $idea->title }}</td>
            <td>{{ $idea->description }}</td>
            <td>{{ $idea->content }}</td>
            <td>{{ $idea->user_id }}</td>
            <td>{{ $idea->category_id }}</td>
            <td>{{ $idea->submission_id }}</td>
            <td>{{ $idea->create_date }}</td>
            <td>{{ $idea->last_modified_date }}</td>
            <td>
                <a href="#" class="btn btn-info">Accept Idea</a>
{{--                 <a href="#" class="btn btn-info"><i class="fas fa-edit"></i></a>
                
                <a href="#" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                
                <a href="#" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a> --}}
                
            </td>
        </tbody>
        <?php    
            }
        ?>
        <tfoot>
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Content</th>
            <th>User</th>
            <th>Category</th>
            <th>Submission</th>
            <th>Create Date</th>
            <th>Modify Date</th>
            <th>Action</th>
        </tfoot>
    </table>
    </div>

@endsection