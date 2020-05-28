@extends('layouts.backend.app')

@section('title','Role')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Roles</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render('app.roles.index') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Main content -->
<section class="content">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <span>Manage Roles</span>
            <div class="card-tools">
                <a href="{{ route('app.roles.create') }}" class="btn btn-sm btn-primary">Create New</a>
            </div>
        </div>

        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class="text-center">Permissions</th>
                            @role('admin')
                            <th>Last Modified</th>
                            @endrole
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $key=>$role)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td class="text-center">
                                @if ($role->permissions->count() > 0)
                                    <span class="badge badge-info">{{ $role->permissions->count() }}</span>
                                @else
                                    <span class="badge badge-danger">No permission found :(</span>

                                @endif
                            </td>
                            @role('admin')
                            <td>{{ $role->updated_at }}</td>
                            @endrole
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('app.roles.edit',$role->id) }}"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $role->id }})"><i class="fas fa-trash-alt"></i></button>
                                <form id="delete-form-{{ $role->id }}" action="{{ route('app.roles.destroy',$role->id) }}" method="POST" style="display: none;">
                                    @csrf()
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th class="text-center">Permissions</th>
                            @role('admin')
                            <th>Last Modified</th>
                            @endrole
                            <th class="text-center">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
