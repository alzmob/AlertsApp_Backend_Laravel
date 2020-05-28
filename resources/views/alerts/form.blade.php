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
                <h1>{{ isset($alert) ? 'Edit Alert' : 'Add New Alert' }}</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render(isset($alert) ? 'app.alerts.edit' : 'app.alerts.create', $alert ?? '') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- form start -->
        <form role="form" id="Alertform" method="POST"
            action="{{ isset($alert) ? route('app.alerts.update',$alert->id) : route('app.alerts.store') }}"
            enctype="multipart/form-data">
            @csrf
            @if (isset($alert))
            @method('PUT')
            @endif
            @if (!isset($alert))
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        Media
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="video">Only video are allowed </label>
                            <input type="file" name="video" id="video"
                                class="dropify {{ $errors->has('video') ? ' is-invalid' : '' }}" data-default-file=""
                                data-allowed-file-extensions="mp4 flv mov avi wmv">
                            @if ($errors->has('video'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('video') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            @endif
            <!-- /.card -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            Basic Info
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" placeholder="Enter Title"
                                    value="{{ isset($alert) ? $alert->title : old('title') }}" required autofocus>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="lat">Lat</label>
                                        <input type="text" class="form-control @error('lat') is-invalid @enderror"
                                            id="lat" name="lat" placeholder="Enter first name"
                                            value="{{ isset($alert) ? $alert->lat : old('lat') }}">
                                        @error('lat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="long">Long</label>
                                        <input type="text" class="form-control @error('long') is-invalid @enderror"
                                            id="long" name="long" placeholder="Enter last name"
                                            value="{{ isset($alert) ? $alert->long : old('long') }}">
                                        @error('long')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if (!isset($alert))
                                <div class="form-group">
                                    <label for="description">Please describe current situation.</label>
                                    <textarea class="form-control  @error('description') is-invalid @enderror"
                                        name="description" rows="5"></textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            @endif

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            Select City and Status
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="city">Select City</label>
                                <select id="city" class="form-control select @error('city') is-invalid @enderror"
                                    name="city" required>
                                    @foreach($cities as $key=>$city)
                                    <option @if(isset($alert)) {{ $city->id == $alert->city->id ? 'selected' : '' }}
                                        @endif value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="user">Select User</label>
                                <select id="user" class="form-control select @error('user') is-invalid @enderror"
                                    name="user" required>
                                    @foreach($users as $key=>$user)
                                    <option @if(isset($alert)) {{ $user->id == $alert->user->id ? 'selected' : '' }}
                                        @endif value="{{ $user->id }}">{{ $user->first_name .' '. $user->last_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('user')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="published" name="published"
                                    @isset($alert) {{ $alert->published == true ? 'checked' :'' }} @endisset>
                                <label class="custom-control-label" for="published">Published</label>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('app.alerts.index') }}" class="btn btn-danger pull-right">Back</a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($alert) ? 'Update' : 'Save' }}</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@push('js')

@endpush
