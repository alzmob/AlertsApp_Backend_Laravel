@extends('layouts.backend.app')

@section('title','Permission')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($permission) ? 'Edit ' : 'Add New' }} Permission</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render(isset($permission) ? 'app.permissions.edit' : 'app.permissions.create',isset($permission) ? $permission : '') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <span>All available permissions</span>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form role="form" method="POST" action="{{ route('app.permissions.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="select-all">
                                    <label class="custom-control-label" for="select-all">Select All</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($routes as $key=>$route)
                                @if ($route->getName() !==  null && starts_with($route->getName(),'app.'))
                                <div class="col-md-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="permission-{{ $key }}" name="permissions[]" value="{{ $route->getName() }}"
                                        @foreach($permissions as $permission)
                                            {{ $permission->name === $route->getName() ? 'disabled' : '' }}
                                            @endforeach>
                                        <label class="custom-control-label" for="permission-{{ $key }}">{{ $route->getName() }}</label>
                                    </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <a href="{{ route('app.permissions.index') }}" class="btn btn-danger">Back</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('js')
    <script type="text/javascript">
        // Listen for click on toggle checkbox
        $('#select-all').click(function(event) {
            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });
    </script>
@endpush
