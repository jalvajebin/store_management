@extends('admin.layouts.dashboard')
@section('title', 'Stores')
@section('content')
    <div class="app-main flex-column flex-row-fluid">
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Stores
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.dashboard.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.stores.index') }}" class="text-muted text-hover-primary"> Stores </a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                Create
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="app-content flex-column-fluid">
                <div class="app-container container-xxl">
                    <div class="card card-flush">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.stores.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <div class="fv-row">
                                            <label class="form-label" for="name">Name</label>
                                            <input class="form-control" id="name" name="name" type="text" placeholder="Name" value="{{ old('name') }}">
                                            @error('name')
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <div class="fv-row">
                                            <label class="form-label" for="address"> Address </label>
                                            <textarea class="form-control" id="address" name="address" type="text" placeholder="Address">{{ old('address') }}</textarea>
                                            @error('address')
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <div class="fv-row">
                                            <label class="form-label" for="latitude"> Latitude </label>
                                            <input class="form-control" id="latitude" name="latitude" type="text" placeholder="Latitude" value="{{ old('latitude') }}">
                                            @error('latitude')
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <div class="fv-row">
                                            <label class="form-label" for="longitude">Longitude</label>
                                            <input class="form-control" id="longitude" name="longitude" type="text" placeholder="Longitude" value="{{ old('longitude') }}">
                                            @error('longitude')
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <div class="fv-row">
                                            <label class="form-label" for="image">Image</label>
                                            <input class="form-control" id="image" name="image" type="file">
                                            @error('image')
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <div class="fv-row">
                                            <label class="form-label" for="radius">Radius</label>
                                            <input class="form-control" id="radius" name="radius" type="text" placeholder="Radius" value="{{ old('radius') }}">
                                            @error('radius')
                                            <div class="fv-plugins-message-container invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary float-end">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function () {
            tinymce.init({
                selector: '#content',
                menubar: false,
                placeholder: 'Content',
            });
        });
    </script>
@endpush
