@extends('layouts.adminlayout')
@section('AdminContent')
    <div class="container">
        <p><strong>User: </strong>{{ $user->name }}</p>
        <p>
            <strong>Role: </strong>
            <ul>
                @foreach($user->roles as $user_role)
                <li>
                    
                    {{ $user_role->name }}
                    
                </li>
                @endforeach
            </ul>
        </p>
    </div>
@endsection