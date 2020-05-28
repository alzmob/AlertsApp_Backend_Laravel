@extends('layouts.backend.app')

@section('title','Dashboard')

@push('css')

@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                {{ Breadcrumbs::render('app.dashboard') }}
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalCities }}</h3>

                        <p>Total Cities</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-city"></i>
                    </div>
                    <a href="{{ route('app.cities.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalAlerts }}</h3>

                        <p>Total Alerts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <a href="{{ route('app.alerts.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalPendingAlerts }}</h3>

                        <p>Pending Alerts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-bell-slash"></i>
                    </div>
                    <a href="{{ route('app.alerts.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalUsers }}</h3>

                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{ route('app.users.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <span>Recent Pending Alerts</span>
                        <div class="card-tools">
                            <a href="{{ route('app.alerts.index') }}" class="btn btn-sm btn-primary">See All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="" class="table table-striped table-hover">
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
                                    @forelse($alerts as $key=>$alert)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td style="width: 20%">
                                            ​<picture>
                                                <source
                                                    srcset="{{ $alert->getFirstMediaUrl('videos','thumb') != null ? $alert->getFirstMediaUrl('videos','thumb') : config('app.placeholder').'160' }}"
                                                    type="image/svg+xml">
                                                <img src="{{ $alert->getFirstMediaUrl('videos','thumb') != null ? $alert->getFirstMediaUrl('videos','thumb') : config('app.placeholder').'160' }}"
                                                    class="img-thumbnail" alt="alert thumb" height="150px"
                                                    width="150px">
                                            </picture>
                                        </td>
                                        <td>
                                            <a href="{{ route('app.alerts.show',$alert->id) }}">
                                                {{ Str::limit($alert->title,40) }}
                                            </a>
                                        </td>
                                        <td>{{ $alert->user->first_name ?? '' }}</td>
                                        <td>{{ $alert->city->name ?? '' }}</td>
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
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('app.alerts.edit',$alert->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteData({{ $alert->id }})"><i
                                                    class="fas fa-trash-alt"></i></button>
                                            <form id="delete-form-{{ $alert->id }}"
                                                action="{{ route('app.alerts.destroy',$alert->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf()
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr class="text-center">
                                        <td colspan="8">
                                            <strong>All caught up. No Recent alerts.</strong>
                                        </td>
                                    </tr>
                                    @endforelse
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
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
@endsection

@push('js')

@endpush
