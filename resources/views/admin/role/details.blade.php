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
                <a href="{{ route('view.role') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Return Role List</a>
            </div>
            <div class="card">
                <div class="card-header bg-primary text-white">Details Role {{ $role->name }}</div>
                <div class="card-body">
                  {{-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> --}}
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Role: <strong>{{ $role->name }}</strong></label>
                </div>
                <div class="mt-3">
                    <label for="exampleFormControlInput1" class="form-label">Routes</label>
                </div>
                {{-- Route List --}}
                <div class="row">
                    <div class="col-md-12">
                        @if ($myroutes)
                            @foreach ($myroutes as $key => $route)
                                <button class="btn btn-success mt-3" disabled>{{ $route }}</button>
                            @endforeach
                        @endif
                        @if($myroutes == null)
                            <p>This User Don't Have Any Permission</p>
                        @endif
                    </div>
                </div>
                
                {{-- End Route List --}}
                </div>
              </div>
        </form>
    </div>
@endsection