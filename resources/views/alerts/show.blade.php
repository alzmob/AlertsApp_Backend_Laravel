@extends('layouts.backend.app')

@section('title','Alert')

@push('css')
<link rel="stylesheet" href="https://unpkg.com/plyr@3/dist/plyr.css">
@endpush
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Alert Details</h1>
            </div>
            <div class="col-sm-6">
                {{ Breadcrumbs::render('app.alerts.show', $alert ?? '') }}
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="{{ $alert->getFirstMediaUrl('videos','thumb') ? $alert->getFirstMediaUrl('videos','thumb') : config('app.placeholder').'500'  }}" class="card-img" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $alert->title }}</h5>
                        <p class="card-text">{{ $alert->updates->first()->description }}</p>
                        <p class="card-text"><small class="text-muted">Last updated
                                {{ $alert->updated_at->diffForHumans() }}</small></p>
                        <a class="btn btn-info btn-sm" href="{{ route('app.alerts.edit',$alert->id) }}"><i
                                class="fas fa-edit"></i>Edit</a>
                        <button type="button" class="btn btn-danger btn-sm" onclick="deleteData({{ $alert->id }})"><i
                                class="fas fa-trash-alt"></i>Delete</button>
                        <form id="delete-form-{{ $alert->id }}" action="{{ route('app.alerts.destroy',$alert->id) }}"
                            method="POST" style="display: none;">
                            @csrf()
                            @method('DELETE')
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="card text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="alertTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="media-tab" data-toggle="tab" href="#media" role="tab"
                            aria-controls="media" aria-selected="true">Media</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="updates-tab" data-toggle="tab" href="#updates" role="tab"
                            aria-controls="updates" aria-selected="false">Updates</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab"
                            aria-controls="comments" aria-selected="false">Comments</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="alertTabContent">
                <div class="tab-pane fade show active" id="media" role="tabpanel" aria-labelledby="media-tab">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary m-2" data-toggle="modal"
                        data-target="#alertUploadModel">
                        <i class="fas fa-upload"></i> Upload Video
                    </button>
                    <div class="row m-2">
                        @forelse ($mediaItems as $media)
                        <div class="col-md-4">
                            <div class="card">
                                <video controls crossorigin playsinline poster="{{ $media->getFullUrl('thumb') }}">
                                    <source src="{{ $media->getFullUrl() }}" type="video/mp4">
                                    <!-- Fallback for browsers that don't support the <video> element -->
                                    <a href="{{ $media->getFullUrl() }}" download>Download</a>
                                </video>
                                <div class="card-body">
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="deleteData({{ $media->id }})"><i class="fas fa-trash-alt"></i>
                                        Delete</button>
                                    <form id="delete-form-{{ $media->id }}"
                                        action="{{ route('app.media.destroy',$media->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf()
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col text-center">
                            <strong>No video found :(</strong>
                        </div>
                        @endforelse

                    </div>
                </div>
                <div class="tab-pane fade" id="updates" role="tabpanel" aria-labelledby="updates-tab">
                    <div class="card-body">
                        <form action="{{ route('app.alerts.updates.store',['alertId'=>$alert->id]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control  @error('description') is-invalid @enderror"
                                    name="description" rows="3"
                                    placeholder="Please describe current situation."></textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <br>
                            <button type="submit" class="btn btn-info pull-right">Post</button>
                        </form>
                        <div class="clearfix"></div>
                        <hr>
                        @forelse ($alert->updates()->latest()->get() as $update)
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    <p class="text-secondary text-left">
                                        {{ $update->created_at ? $update->created_at->diffForHumans() : null }}</p>
                                    <p class="text-left">{{ $update->description }}</p>
                                    <p>
                                        <button type="button" class="float-right btn text-white btn-danger btn-sm"
                                            onclick="deleteData({{ $update->id  }})"><i class="fas fa-trash-alt"></i>
                                            Delete</button>
                                        <form id="delete-form-{{ $update->id  }}"
                                            action="{{ route('app.alerts.updates.destroy',['alertId'=>$alert->id,'comment' => $update->id]) }}"
                                            method="POST" style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                    </p>
                            </div>
                        </div>
                        @empty
                        <strong>No comment found :(</strong>
                        @endforelse
                    </div>
                </div>
                <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                    <div class="card-body">
                        <form action="{{ route('app.alerts.comments.store',['alertId'=>$alert->id]) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <textarea class="form-control  @error('comment_body') is-invalid @enderror"
                                    name="comment_body" rows="3" placeholder="write a comment"></textarea>
                                @error('comment_body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <br>
                            <button type="submit" class="btn btn-info pull-right">Post</button>
                        </form>
                        <div class="clearfix"></div>
                        <hr>
                        @forelse ($alert->comments()->latest()->get() as $comment)
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{ $comment->user->getFirstMediaUrl('avatar') != null ? $comment->user->getFirstMediaUrl('avatar')  : config('app.placeholder').'160' }}"
                                    class="img img-rounded img-fluid" />
                                <p class="text-secondary text-center">
                                    {{ $comment->created_at ? $comment->created_at->diffForHumans() : null }}</p>
                            </div>
                            <div class="col-md-10">
                                <p>
                                    <strong class="float-left">{{ $comment->user->first_name }}</strong>
                                    <div class="clearfix"></div>
                                    <p class="text-left">{{ $comment->body }}</p>
                                    <p>
                                        <button type="button" class="float-right btn text-white btn-danger btn-sm"
                                            onclick="deleteData({{ $comment->id  }})"><i class="fas fa-trash-alt"></i>
                                            Delete</button>
                                        <form id="delete-form-{{ $comment->id  }}"
                                            action="{{ route('app.alerts.comments.destroy',['alertId'=>$alert->id,'comment' => $comment->id]) }}"
                                            method="POST" style="display: none;">
                                            @csrf()
                                            @method('DELETE')
                                        </form>
                                    </p>
                            </div>
                        </div>
                        @empty
                        <strong>No comment found :(</strong>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
    <!-- Modal -->
    <div class="modal fade" id="alertUploadModel" tabindex="-1" role="dialog" aria-labelledby="alertUploadModelLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertUploadModelLabel">Upload New Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('app.alerts.upload',$alert->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
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
                        <div class="form-group">
                            <textarea class="form-control  @error('description') is-invalid @enderror"
                                name="description" rows="3" placeholder="Please describe current situation."></textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection

@push('js')
<script
    src="https://cdn.polyfill.io/v2/polyfill.min.js?features=es6,Array.prototype.includes,CustomEvent,Object.entries,Object.values,URL">
</script>
<script src="https://unpkg.com/plyr@3"></script>
<script>
    const players = {};

    Array.from(document.querySelectorAll('video')).forEach(video => {
        players[video.id] = new Plyr(video);
    });

</script>
@endpush
