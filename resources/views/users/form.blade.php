@extends('layouts.backend.app')

@section('title','User')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($user) ? 'Edit User' : 'Add New User' }}</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render(isset($user) ? 'app.users.edit' : 'app.users.create', $user ?? '') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- form start -->
        <form role="form" id="userform" method="POST" action="{{ isset($user) ? route('app.users.update',$user->id) : route('app.users.store') }}" enctype="multipart/form-data">
            @csrf
            @if (isset($user))
                @method('PUT')
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            Basic Info
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" value="{{ isset($user) ? $user->first_name : old('first_name') }}" required autofocus>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" value="{{ isset($user) ? $user->last_name : old('last_name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone_number">Phone Number</label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter phone number" value="{{ isset($user) ? $user->phone_number : old('phone_number') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ isset($user) ? $user->email : old('email') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="******" {{ isset($user) ? '' : 'required' }}>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="******" {{ isset($user) ? '' : 'required' }}>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            Select Roles and Status
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="roles">Select Roles</label>
                                <select id="roles" class="form-control select js-example-basic-multiple" name="roles[]" multiple="multiple" required>
                                    @foreach($roles as $key=>$role)
                                        <option
                                            @if(isset($user))
                                            @foreach($user->roles as $userRole)
                                            {{ $role->id == $userRole->id ? 'selected' : '' }}
                                            @endforeach
                                            @endif
                                            value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('app.users.index') }}" class="btn btn-danger pull-right">Back</a>
                            <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Save' }}</button>
                        </div>
                    </div>
                    <!-- /.card -->

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            Image
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="avatar">Only image are allowed </label>
                                <input type="file" name="avatar" id="avatar"
                                       class="dropify {{ $errors->has('avatar') ? ' is-invalid' : '' }}" data-default-file="{{ isset($user) ? $user->getFirstMediaUrl('avatar') : config('app.placeholder').'160' }}">
                                @if ($errors->has('avatar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
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
