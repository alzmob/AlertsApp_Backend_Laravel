@extends('layouts.backend.app')

@section('title','Cities')

@push('css')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cities</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render('app.cities.index') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="card card-primary card-outline">
        <div class="card-header">
            <span>Manage Cities</span>
            <div class="card-tools">
                <a href="{{ route('app.cities.create') }}" class="btn btn-sm btn-primary">Create New</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Alerts</th>
                            @role('admin')
                            <th>Timestamp</th>
                            @endrole
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cities as $key=>$city)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $city->name }}</td>
                            <td style="width: 20%">
                                <span class="badge badge-info">{{ $city->alerts->count() }}</span>
                            </td>
                            @role('admin')
                            <td>{{ $city->updated_at }}</td>
                            @endrole
                            <td class="text-center">
                                <a class="btn btn-info btn-sm" href="{{ route('app.cities.edit',$city->id) }}"><i
                                        class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteData({{ $city->id }})"><i class="fas fa-trash-alt"></i></button>
                                <form id="delete-form-{{ $city->id }}"
                                    action="{{ route('app.cities.destroy',$city->id) }}" method="POST"
                                    style="display: none;">
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
                            <th>Alerts</th>
                            @role('admin')
                            <th>Timestamp</th>
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
