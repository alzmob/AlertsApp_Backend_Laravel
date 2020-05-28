@extends('layouts.backend.app')

@section('title','Permission')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Permissions</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render('app.permissions.index') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <span>Manage permissions.</span>
            <div class="card-tools">
                <a href="{{ route('app.permissions.create') }}" class="btn btn-sm btn-primary">Create New</a>
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
                        @role('admin')
                        <th>Last Modified</th>
                        @endrole
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $key=>$permission)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $permission->name }}</td>
                            @role('admin')
                            <td>{{ $permission->updated_at }}</td>
                            @endrole
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $permission->id }})"><i class="fas fa-trash-alt"></i></button>
                                <form id="delete-form-{{ $permission->id }}" action="{{ route('app.permissions.destroy',$permission->id) }}" method="POST" style="display: none;">
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

