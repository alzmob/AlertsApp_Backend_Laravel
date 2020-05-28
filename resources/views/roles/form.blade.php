@extends('layouts.backend.app')

@section('title','Role')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($role) ? 'Edit' : 'Add New' }} Role</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render(isset($role) ? 'app.roles.edit' : 'app.roles.create',isset($role) ? $role : '') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <span>{{ isset($role) ? 'Manage' : 'Create' }} Role</span>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ isset($role) ? route('app.roles.update',$role->id) : route('app.roles.store') }}">
                @csrf
                @if (isset($role))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Role Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter role name" value="{{ isset($role) ? $role->name : old('name') }}" required autofocus>
                    </div>
                    <div class="text-center">
                        <strong>Manage permissions for new role</strong>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="select-all">
                        <label class="custom-control-label" for="select-all">Select All</label>
                    </div>
                    @forelse($permissions->chunk(3) as $chunks)
                        <div class="row">
                            @foreach($chunks as $key=>$permission)
                            <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="permission-{{ $key }}" name="permissions[]" value="{{ $permission->id }}"
                                    @if(isset($role))
                                        @foreach($role->permissions as $rPermission)
                                            {{ $permission->id == $rPermission->id ? 'checked' : '' }}
                                        @endforeach
                                    @endif>
                                    <label class="custom-control-label" for="permission-{{ $key }}">{{ $permission->name }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @empty
                        <div class="row">
                            <div class="col-12 text-center">
                                <strong>No Premissions Found. <a href="{{ route('app.permissions.create') }}">Create New</a></strong>
                            </div>
                        </div>
                    @endforelse
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href="{{ route('app.roles.index') }}" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">{{ isset($role) ? 'Update' : 'Save' }}</button>
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
