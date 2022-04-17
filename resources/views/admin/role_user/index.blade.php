@extends('layouts.adminlayout')
@section('AdminContent')

    <div class="col-md-12 text-center">
        <h3><strong>Assign User To Role</strong></h3>
    </div>
    <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
    <div class="col-md-12 mb-3">
        <a href="{{URL::to('/admin/user-role/create')}}" class="btn btn-success"><i class="fas fa-plus"></i> Create New</a>
    </div>
    <div class="col-md-12">
            <table class="table">
        <thead class="table-dark">
            <th>#</th>
            <th>FullName</th>
            <th>Type</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php
                foreach($users as $user)
                {
            ?>
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->type }}</td>
                    <td>
                        <a href="{{ URL::to('/admin/user-role/edit/'.$user->id) }}" class="btn btn-info"><i class="fas fa-edit"></i> Edit User Role</a>
                        
                        <a href="{{ URL::to('/admin/user-role/details/'.$user->id) }}" class="btn btn-warning"><i class="fas fa-eye"></i> Details User Role</a>
                        
                        <a href="{{ URL::to('/admin/user-role/delete/'.$user->id) }}" onclick="return confirm('Are you sure?')" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete User Role</a>
                    </td>
                </tr>
            <?php    
                }
            ?>
        </tbody>
 
    </table>
    </div>

@endsection