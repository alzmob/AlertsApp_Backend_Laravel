@extends('layouts.backend.app')

@section('title','City')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ isset($city) ? 'Edit City' : 'Add New City' }}</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render(isset($city) ? 'app.cities.edit' : 'app.cities.create', $city ?? '') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- form start -->
        <form role="form" id="cityform" method="POST"
            action="{{ isset($city) ? route('app.cities.update',$city->id) : route('app.cities.store') }}">
            @csrf
            @if (isset($city))
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
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="Enter last name"
                                    value="{{ isset($city) ? $city->name : old('name') }}">
                                @error('name')
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
                                            value="{{ isset($city) ? $city->lat : old('lat') }}">
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
                                            value="{{ isset($city) ? $city->long : old('long') }}">
                                        @error('long')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a href="{{ route('app.cities.index') }}" class="btn btn-danger">Back</a>
                            <button type="submit"
                                class="btn btn-primary">{{ isset($city) ? 'Update' : 'Save' }}</button>
                        </div>
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
<script>
    function getLatLong() {
            if ("geolocation" in navigator){ //check geolocation available
                //try to get user current location using getCurrentPosition() method
                navigator.geolocation.getCurrentPosition(function(position){
                    $('#lat').val(position.coords.latitude)
                    $('#long').val(position.coords.longitude)
                        console.log("Found your location <br />Lat : "+position.coords.latitude+" </br>Lang :"+ position.coords.longitude)
                    });
            }else{
                console.log("Browser doesn't support geolocation!");
            }
        }getLatLong()
</script>
@endpush
