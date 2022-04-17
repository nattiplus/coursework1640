@extends('layouts.adminlayout')
@section('AdminContent')
    <div class="col-md-12">
        <?php
            $message = Session::get('message');
            if($message){
                echo '<span class="text-alert" style="color: red;">'.$message.'</span>';
                Session::put('message',null);
            }
        ?>
            <form role="form" action="{{ route('user_role.create.post') }}" method="post">
                {{csrf_field()}}
            <div class="mb3">
                <h1 class="text-center">Create User Role</h1>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">User</label>
                <select class="form-check-label" name="user_select[]" multiple>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Role</label>
                <select class="form-check-label" name="role_select[]" multiple>
                    @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" name="add_user" class="btn btn-primary mt-3">Create</button>
        </form>
    </div>
@endsection