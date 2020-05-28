@extends('layouts.backend.app')

@section('title','Alert')

@push('css')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Alerts</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render('app.alerts.index') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <div class="card card-primary card-outline">
        <div class="card-header">
            <span>Manage Alerts</span>
            <div class="card-tools">
                <a href="{{ route('app.alerts.create') }}" class="btn btn-sm btn-primary">Create New</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Media</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Status</th>
                            @role('admin')
                            <th>Timestamp</th>
                            @endrole
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alerts as $key=>$alert)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                ​<picture>
                                    <source
                                        srcset="{{ $alert->getFirstMediaUrl('videos','thumb') != null ? $alert->getFirstMediaUrl('videos','thumb') : config('app.placeholder').'160' }}"
                                        type="image/svg+xml">
                                    <img src="{{ $alert->getFirstMediaUrl('videos','thumb') != null ? $alert->getFirstMediaUrl('videos','thumb') : config('app.placeholder').'160' }}"
                                        class="img-thumbnail" alt="alert thumb" height="150px" width="150px">
                                </picture>
                            </td>
                            <td>
                                <a href="{{ route('app.alerts.show',$alert->id) }}">
                                    {{ Str::limit($alert->title,40) }}
                                </a>
                            </td>
                            <td>{{ $alert->user->first_name  ?? ''}}</td>
                            <td>{{ $alert->city->name ?? ''}}</td>
                            <td style="width: 5%">
                                @if ($alert->published)
                                <span class="badge badge-info">Published</span>
                                @else
                                <span class="badge badge-danger">Pending</span>
                                @endif
                            </td>
                            @role('admin')
                            <td style="width: 2%">{{ \Carbon\Carbon::parse($alert->updated_at)->diffForHumans() }}</td>
                            @endrole
                            <td class="text-center" style="width: 10%">
                                <a class="btn btn-info btn-sm" href="{{ route('app.alerts.edit',$alert->id) }}"><i
                                        class="fas fa-edit"></i></a>
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="deleteData({{ $alert->id }})"><i class="fas fa-trash-alt"></i></button>
                                <form id="delete-form-{{ $alert->id }}"
                                    action="{{ route('app.alerts.destroy',$alert->id) }}" method="POST"
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
                            <th>Media</th>
                            <th>Title</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Status</th>
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
