@extends('layouts.master-layout')
@section('title')
    Documents
@endsection
@section('current-page')
    Documents
@endsection
@section('extra-styles')

@endsection
@section('breadcrumb-action-btn')
   Documents
@endsection

@section('main-content')
    @if(session()->has('success'))
        <div class="row" role="alert">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="mdi mdi-check-all me-2"></i>

                            {!! session()->get('success') !!}

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 mb-2 d-flex justify-content-end">
            <div class="btn-group">
                <a href="{{route('cloud-storage')}}" class="btn btn-primary">Documents <i class="bx bxs-note"></i> </a>
                <a href="{{url()->previous()}}" class="btn btn-warning">Go Back <i class="bx bx-left-arrow"></i> </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">New Attachments</div>
                <div class="card-body">
                    <div class="col-xl-12 col-md-12 col-lg-12">
                        <h4 class="card-title">Documents</h4>
                        <p class="card-title-desc">Create folder structures to organize your files or choose a certain directory to upload files</p>
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">File</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Folder</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="home1" role="tabpanel">
                                <form action="{{route('upload-files')}}" autocomplete="off" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="">File Name</label>
                                        <input type="text" name="fileName" placeholder="File Name" class="form-control">
                                        @error('fileName')
                                        <i class="text-danger mt-2">{{$message}}</i>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Attachment</label>
                                        <input type="file" name="attachments[]" class="form-control-file" multiple>
                                        @error('attachment')
                                        <i class="text-danger mt-2">{{$message}}</i>
                                        @enderror
                                        <input type="hidden" name="folder" value="0">
                                    </div>
                                    <hr>
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="btn-group">
                                            <a href="{{url()->previous()}}" class="btn btn-warning btn-mini"><i class="bx bx-left-arrow mr-2"></i> Go Back</a>
                                            <button type="submit" class="btn btn-primary"><i class="bx bx-cloud-upload mr-2"></i> Upload File(s)</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="profile1" role="tabpanel">
                                <form action="{{route('create-folder')}}" autocomplete="off" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Folder Name</label>
                                        <input type="text" name="folderName" placeholder="Folder Name" class="form-control">
                                        @error('folderName')
                                        <i class="text-danger mt-2">{{$message}}</i>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Parent Folder</label>
                                        <select name="parentFolder" id="parentFolder" class="form-control">
                                            <option value="0" selected>None</option>
                                            @foreach($folders as $folder)
                                                <option value="{{$folder->id}}">{{$folder->folder ?? ''}}</option>
                                            @endforeach
                                        </select>
                                        @error('parentFolder')
                                        <i class="text-danger mt-2">{{$message}}</i>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Visibility</label>
                                        <select name="visibility" id="visibility" class="form-control">
                                            <option disabled selected>--Select visibility--</option>
                                            <option value="1">Private</option>
                                            <option value="2">Public</option>
                                        </select>
                                        @error('visibility')
                                        <i class="text-danger mt-2">{{$message}}</i>
                                        @enderror
                                    </div>
                                    <hr>
                                    <div class="form-group d-flex justify-content-center">
                                        <div class="btn-group">
                                            <a href="{{url()->previous()}}" class="btn btn-warning btn-mini"><i class="bx bx-left-arrow mr-2"></i> Go Back</a>
                                            <button type="submit" class="btn btn-primary"><i class="bx bx-folder mr-2"></i> Create Folder</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Browse Files & Folders</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($folders as $folder)
                            @if($folder->parent_id == 0)
                                <div class="col-md-2">
                                    <a href="{{route('open-folder', ['slug'=>$folder->slug])}}" title="{{$folder->folder ?? 'No name'}}" data-original-title="{{$folder->folder ?? 'No name'}}" style="cursor: pointer;">
                                        <img src="/assets/formats/folder.png" height="64" width="64" alt="{{$folder->folder ?? 'No name'}}"><br>
                                        {{strlen($folder->folder ?? 'No name') > 20 ? substr($folder->folder ?? 'No name',0,17).'...' : $folder->folder ?? 'No name'}}
                                    </a>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12">
                                            <div class="dropdown mb-2">
                                                <a class="font-size-16 text-muted" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" style="">
                                                    <a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#folderModal_{{$folder->id}}"><i class="bx bx-trash mr-2 text-danger"></i> Delete</a>
                                                </div>
                                            </div>
                                            <div id="folderModal_{{$folder->id}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="card-header bg-custom">
                                                            <h5 class="modal-title text-white" id="exampleModalLabel">Warning</h5>
                                                        </div>
                                                        <form action="{{route('delete-folder')}}" method="post">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="">This action cannot be undone. Are you sure you want to delete <strong>{{$folder->folder ?? '' }}</strong>?</label>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="folder_key"  value="{{$folder->id}}">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="btn-group">
                                                                    <button data-bs-dismiss="modal" type="button" class="btn btn-secondary btn-mini"><i class="bx bx-block mr-2"></i>No, cancel</button>
                                                                    <button type="submit" class="btn btn-danger btn-mini"><i class="bx bx-check mr-2"></i>Yes, delete</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @foreach ($files as $file)
                            @switch(pathinfo($file->filename, PATHINFO_EXTENSION))
                                @case('pptx')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}" style="cursor: pointer;">
                                        <img src="/assets/formats/ppt.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>

                                @break
                                @case('pdf')
                                <div class="col-md-2 mb-4">
                                    <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}" style="cursor: pointer;">
                                        <img src="/assets/formats/pdf.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"> <br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break

                                @case('csv')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/csv.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('xls')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/xls.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('xlsx')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/xls.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('doc')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/doc.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('doc')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/doc.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('docx')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/doc.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('jpeg')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/jpg.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('jpg')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/jpg.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('png')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;"  data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/png.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('gif')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/gif.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('ppt')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/ppt.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('txt')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/txt.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('css')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/css.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"> <br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('mp3')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/mp3.png" height="64" width="64" alt=""><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('mp4')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/mp4.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('svg')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/svg.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('xml')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/xml.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                                @case('zip')
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="tooltip" data-placement="top" title="{{$file->name ?? 'No name'}}" data-original-title="{{$file->name ?? 'No name'}}">
                                        <img src="/assets/formats/zip.png" height="64" width="64" alt="{{$file->name ?? 'No name'}}"><br>
                                        {{strlen($file->name ?? 'No name') > 10 ? substr($file->name ?? 'No name',0,7).'...' : $file->name ?? 'No name'}}
                                    </a>
                                    @include('storage.partials._drop-menu')
                                </div>
                                @break
                            @endswitch
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-scripts')



@endsection
