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
            <div class="mb-3">
                <a href="{{ route('view.user') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Return User List</a>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white">Details User {{ $user->name }}</div>
                <div class="card-body">
                  {{-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Full Name: <strong>{{ $user->name }}</strong></label>
                </div>
                <div class="mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Roles:</label>
                </div>
                {{-- Route List --}}
                <?php 
                    $routeCollection = Illuminate\Support\Facades\Route::getRoutes();
                    $count = 0;
                    
                ?>
                <div class="row">
                    <div class="col-md-2 mb-1">
                        @if ($user_role->isNotEmpty())
                            @foreach ($user_role as $key => $role)
                                <button class="btn btn-success" disabled>{{ $role->name }}</button>
                            @endforeach
                        @endif
                        @if($user_role->isEmpty())
                            <p>This User Don't Have Any Role</p>
                        @endif
                    </div>
                </div>
                
                {{-- End Route List --}}
                </div>
              </div>
        </form>
    </div>
@endsection