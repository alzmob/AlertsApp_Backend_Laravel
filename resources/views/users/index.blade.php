@extends('layouts.backend.app')

@section('title','User')

@push('css')
<style>

</style>
@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render('app.users.index') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="card card-primary card-outline">
        <div class="card-header">
            <span>Manage Users</span>
            <div class="card-tools">
                <a href="{{ route('app.users.create') }}" class="btn btn-sm btn-primary">Create New</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Roles</th>
                            @role('admin')
                            <th>Last Modified</th>
                            @endrole
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key=>$user)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="user-panel">
                                <div class="image">
                                    <img src="{{ $user->getFirstMediaUrl('avatar') != null ? $user->getFirstMediaUrl('avatar','thumb') : config('app.placeholder').'160' }}" alt="User Image" class="img-circle elevation-2">
                                </div>
                            </td>
                            <td>{{ $user->first_name }}</td>
                            <td style="width: 20%">
                                @forelse($user->roles as $key=>$role)
                                    <span class="badge badge-info">{{ $role->name }}</span>
                                @empty
                                    <span class="badge badge-danger">No permission found :(</span>
                                @endforelse
                            </td>
                            @role('admin')
                            <td>{{ $user->updated_at }}</td>
                            @endrole
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('app.users.edit',$user->id) }}"><i class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $user->id }})"><i class="fas fa-trash-alt"></i></button>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('app.users.destroy',$user->id) }}" method="POST" style="display: none;">
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
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Permissions</th>
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
