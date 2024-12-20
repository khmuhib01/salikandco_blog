@extends('layouts.admin.layer')
@section('title', 'Edit Content | Boston Admin Panel')
@section('content')
<script src="{{url('assets/admin/js/bootbox.js')}}"></script>
<script src="{{ url('assets/admin/js/ckeditor/ckeditor.js') }}"></script>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">Home</a>

            <span class="divider">
                <i class="icon-angle-right arrow-icon"></i>
            </span>
        </li>
        <li class="active">Edit Content</li>
    </ul>
    <!--.breadcrumb-->
</div>

<div class="page-content">
    <div class="page-header position-relative">
        <h1>Edit Content</h1>
    </div>
    <!--/.page-header-->

    <div class="row-fluid">
        <div class="span12">
            <div class="control-group">
                @if (!empty(Session::get('message')) && Session::get('message')['status'] == '1')
                <div class="control-group">
                    <div class="alert alert-success inline">
                        {{ Session::get('message')['text'] }}
                    </div>
                </div>
                @elseif (!empty(Session::get('message')) && Session::get('message')['status'] == '0')
                <div class="control-group">
                    <div class="alert alert-danger inline">
                        {{ Session::get('message')['text'] }}
                    </div>
                </div>
                @endif
            </div>
            <!--PAGE CONTENT BEGINS-->
            <form action="{{ route('admin.content.update') }}" accept-charset="utf-8" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $getContent->id }}" name="id">
                <div class="control-group">
                    <label class="control-label" for="category_id">Category</label>
                    <div class="controls">
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select Page</option>
                            {{ $category_id = old('category_id') ?  old('category_id') : $getContent->categories_id }}
                            @if (count($nav_lists) > 0)
                                @foreach ($nav_lists as $nav)
                                    @if ($category_id == $nav->id)
                                        <option value="{{$nav->id}}" selected>{{$nav->name}}</option>
                                    @else
                                    <option value="{{$nav->id}}">{{$nav->name}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('category_id'))
                            <strong>{{ $errors->first('category_id') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="title">Title</label>
                    <div class="controls">
                        <input type="text" name="title" id="title" value="{{ old('title') ? old('title') : $getContent->title }}" class="form-control" onchange="makeSlug(this.value)">
                        @if ($errors->has('title'))
                            <strong>{{ $errors->first('title') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="title">Slug</label>
                    <div class="controls">
                        <input type="text" name="slug" id="slug" value="{{ old('slug') ? old('slug') : $getContent->slug }}" class="form-control">
                        @if ($errors->has('slug'))
                            <strong>{{ $errors->first('slug') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="content">Content</label>
                    <div class="controls">
                        
                        <textarea name="content" id="content" class="form-control">{{ old('content') ? old('content') : $getContent->description }}</textarea>
                        @if ($errors->has('content'))
                            <strong>{{ $errors->first('content') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="title">Mata Title</label>
                    <div class="controls">
                        <input type="text" name="mata_title" id="mata_title" value="{{ old('mata_title') ? old('mata_title') : $getContent->mata_title }}" class="form-control">
                        @if ($errors->has('mata_title'))
                            <strong>{{ $errors->first('mata_title') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="title">Mata Description</label>
                    <div class="controls">
                        <textarea name="mata_description" class="form-control">{{ old('mata_description') ? old('mata_description') : $getContent->mata_description }}</textarea>
                        @if ($errors->has('mata_description'))
                            <strong>{{ $errors->first('mata_description') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="title">Image</label>
                    <div class="controls">
                        <input type="file" name="image" class="form-control">
                        <br><b><span>Image Dimension: 1280 x 640</span></b>
                        <br><b><span>mimes: jpeg,jpg,png</span></b>
                        <br><b><span>Size Max: 2MB</span></b>
                        @if ($errors->has('image'))
                            <strong>{{ $errors->first('image') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Previous Image</label>
                    <div class="controls">
                        @if ($getContent->image !="")
                            <img src="{{ url('public/storage/image/post_image/thumbnail/small/'.$getContent->image) }}" alt="post-image-{{$getContent->id}}">
                        @else
                            <img src="{{ url('public/storage/image/no-image.png') }}" alt="no-image" style="width: 100px; hight:100px;">
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="page">Status</label>
                    <div class="controls">
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ old('status') == 'publish' ? 'selected' : $getContent->status == 'publish' ? 'selected' : ''}}>Publish</option>
                            <option value="0" {{ old('status') == 'private' ? 'selected' : $getContent->status == 'private' ? 'selected' : ''}}>Private</option>
                            <option value="0" {{ old('status') == 'draft' ? 'selected' : $getContent->status == 'draft' ? 'selected' : ''}}>Draft</option>
                        </select>
                        @if ($errors->has('status'))
                            <strong>{{ $errors->first('status') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" value="submit" class="btn btn-info">
                        <i class="icon-ok bigger-110"></i>
                        ADD
                    </button>
                </div>

            </form>

        </div>
        <!--PAGE CONTENT ENDS-->
    </div>
    <!--/.span-->

</div>
<!--/.row-fluid-->
<style>
    .radio.controls.radio-p-0 {
        margin-left: 160px !important;
    }

    label.radio-float {
        float: left;
        margin-right: 10px;
    }

    .pager {
        text-align: left;
    }

    .show-count {
        margin-right: 10px;
    }
</style>

<script>
function makeSlug(value) {
    const str = value.trim().replace(/[^a-zA-Z ]/g, "");
    const slug = str.replace(/\s/g, '-');;
    $('#slug').val(slug.toLowerCase());
}

function editMakeSlug(value) {
    const str = value.trim().replace(/[^a-zA-Z ]/g, "");
    const slug = str.replace(/\s/g, '-');;
    $('#edit_slug').val(slug.toLowerCase());
}

CKEDITOR.replace('content');


</script>

@endsection
