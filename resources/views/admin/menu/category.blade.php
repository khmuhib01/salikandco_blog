@extends('layouts.admin.layer')
@section('title', 'Menu Add | Boston Admin Panel')
@section('content')
<script src="{{url('assets/admin/js/bootbox.js')}}"></script>
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
            <a href="#">Home</a>

            <span class="divider">
                <i class="icon-angle-right arrow-icon"></i>
            </span>
        </li>
        <li class="active">Menu Add</li>
    </ul>
    <!--.breadcrumb-->
</div>

<div class="page-content">
    <div class="page-header position-relative">
        <h1>Menu Add</h1>
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
            <form action="{{ route('admin.menu.store') }}" accept-charset="utf-8" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="control-group">
                    <label class="control-label" for="form-field-1">Name</label>
                    <div class="controls">
                        <input type="text" placeholder="Name" name="name" id="name" value="{{ old('name') }}" onchange="makeSlug(this.value)">
                        @if ($errors->has('name'))
                        <strong>{{ $errors->first('name') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Slug</label>
                    <div class="controls">
                        <input type="text" placeholder="Slug" name="slug" id="slug" value="{{ old('slug') }}">
                        @if ($errors->has('name'))
                        <strong>{{ $errors->first('slug') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Type</label>
                    <div class="radio controls radio-p-0">
                        <label class="radio-float">
                            <input type="radio" name="is_type" class="ace" value="0" onclick="isType(0)" {{ old('is_type') == 0 ? 'checked' : ''}}>
                            <span class="lbl"> Parent</span>
                        </label>
                        <label class="radio-float">
                            <input type="radio" name="is_type" class="ace" value="1" onclick="isType(1)" {{ old('is_type') == 1 ? 'checked' : ''}}>
                            <span class="lbl"> Child</span>
                        </label>
                        @if ($errors->has('is_type'))
                        <strong>{{ $errors->first('is_type') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group" id="parent_id" style="{{ old('is_type') == 1 ? 'display: block' : 'display: none'}}">
                    <label class="control-label" for="form-field-2">Parent Menu</label>
                    <div class="controls">
                        <select class="status" name="parent_id">
                            <option value="">Select parent Menu</option>
                            @foreach ($nav_parents as $nav_parent)
                            @if (old('parent_id') == $nav_parent->id)
                            <option value="{{ $nav_parent->id }}" selected>{{ $nav_parent->name }}</option>
                            @else
                            <option value="{{ $nav_parent->id }}">{{ $nav_parent->name }}</option>
                            @endif
                            @endforeach
                        </select>
                        @if ($errors->has('parent_id'))
                        <strong>{{ $errors->first('parent_id') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Is Specific Page</label>
                    <div class="radio controls radio-p-0">
                        <label class="radio-float">
                            <input type="radio" name="is_specific_page" class="ace" value="0" {{ old('is_specific_page') == 0 ? 'checked' : ''}}>
                            <span class="lbl"> Common</span>
                        </label>
                        <label class="radio-float">
                            <input type="radio" name="is_specific_page" class="ace" value="1" {{ old('is_specific_page') == 1 ? 'checked' : ''}}>
                            <span class="lbl"> Notice</span>
                        </label>
                        <label class="radio-float">
                            <input type="radio" name="is_specific_page" class="ace" value="2" {{ old('is_specific_page') == 2 ? 'checked' : ''}}>
                            <span class="lbl"> Gallery</span>
                        </label>
                        @if ($errors->has('is_specific_page'))
                            <strong>{{ $errors->first('is_specific_page') }}</strong>
                        @endif
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="form-field-1">Is position</label>
                    <div class="radio controls radio-p-0">
                        <label class="radio-float">
                            <input type="radio" name="is_show" class="ace" value="0" {{ old('is_show') == 0 ? 'checked' : ''}}>
                            <span class="lbl"> Header Top</span>
                        </label>
                        <label class="radio-float">
                            <input type="radio" name="is_show" class="ace" value="1" {{ old('is_show') == 1 ? 'checked' : ''}}>
                            <span class="lbl"> Footer Button</span>
                        </label>
                        <label class="radio-float">
                            <input type="radio" name="is_show" class="ace" value="2" {{ old('is_show') == 2 ? 'checked' : ''}}>
                            <span class="lbl"> Both</span>
                        </label>
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

    <div class="row-fluid">
        <div class="table-header">
            Results for "Menu List"
            <span class="text-muted pull-right show-count">Showing {{$records->currentPage()*$records->perPage()-$records->perPage()+1}} to {{ ($records->currentPage()*$records->perPage()>$records->total())?$records->total():$records->currentPage()*$records->perPage()}} of {{$records->total()}} data(s)</span>
        </div>

        <div class="search-box pull-right">
            <form action="{{ url('admin/menu') }}" method="get">
                <div class="control-group">
                    <input type="text" class="from-control search-input-nav" placeholder="Search" name="q" value="{{ Request::get('q') }}">
                    <input type="submit" value="Search" class="search-btn">
                </div>
            </form>
        </div>

        <table id="sample-table-2" class="table table-striped table-bordered table-hover notice-table">
            <thead>
                <tr>
                    <th class="hidden-480">ID</th>
                    <th class="hidden-480">Name</th>
                    <th class="hidden-480">Slug</th>
                    <th class="hidden-480">Type</th>
                    <th class="hidden-480">Page</th>
                    <th class="hidden-480">position</th>
                    <th class="hidden-480">status</th>
                    <th class="hidden-480">Sort</th>
                    <th>Created at</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php $count = 1; @endphp
                @forelse($records as $val)
                    @php
                        
                        if ($val->parent_id == '0') :
                            $type = '<span class="badge badge-success">Parent</span>';
                        else:
                            $type = '<span class="badge badge-info">child of '.getParentName($val->parent_id).'</span>';
                        endif;

                        $page = '<span class="badge badge-info">Common</span>';
                        if ($val->is_specific_page == '1') :
                            $page = '<span class="badge badge-info">Notice</span>';
                        elseif ($val->is_specific_page == '2') :
                            $page = '<span class="badge badge-info">Gallery</span>';
                        endif;

                        $position = '<span class="badge badge-info">Header Top</span>';
                        if ($val->is_show == '1') :
                            $position = '<span class="badge badge-info">Footer Button</span>';
                        elseif ($val->is_show == '2') :
                            $position = '<span class="badge badge-info">Both</span>';
                        endif;
                    @endphp
                <tr>
                    <td>{{ $count }}</td>
                    <td>{{ $val->name }}</td>
                    <td>{{ $val->slug }}</td>
                    <td>{!! $type !!}</td>
                    <td>{!! $page !!}</td>
                    <td>{!! $position !!}</td>
                    <td>{!! $val->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                    <td>
                        <input type="text" id="sort_{{$val->id}}" class="nav-sort" value="{{ $val->sort }}" onchange="navSort({{ $val->id }}, {{ $val->parent_id }})">
                        <input type="hidden" id="is_type_{{$val->id}}" value="{{ $val->parent_id }}">
                    </td>
                    <td>{{ $val->created_at }}</td>
                    <td>
                        <a href="javascript:void(0)" onclick="edit({{ $val->id }})">Edit</a>
                        <a href="javascript:void(0)" onclick="deleteData({{ $val->id }})">Delete</a>
                    </td>
                </tr>
                @php $count++ @endphp
                @empty
                <tr>
                    <td colspan="7">No Data Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        @if ($records->lastPage() > 1)
        <ul class="pager">

            @if ($records->currentPage() != 1 && $records->lastPage() >= 5)
            <li class="previous">
                <a href="{{ $records->url($records->url(1)) }}">
                    << </a> </li> @endif @if($records->currentPage() != 1)
            <li class="previous">
                <a href="{{ $records->url($records->currentPage()-1) }}">
                    < </a> </li> @endif @for($i=max($records->currentPage()-2, 1); $i <= min(max($records->currentPage()-2, 1)+4,$records->lastPage()); $i++)
            <li class="{{ ($records->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $records->url($i) }}">{{ $i }}</a>
            </li>
            @endfor

            @if ($records->currentPage() != $records->lastPage())
            <li>
                <a href="{{ $records->url($records->currentPage()+1) }}">
                    >
                </a>
            </li>
            @endif

            @if ($records->currentPage() != $records->lastPage() && $records->lastPage() >= 5)
            <li>
                <a href="{{ $records->url($records->lastPage()) }}">
                    >>
                </a>
            </li>
            @endif
        </ul>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
                    <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="control-group" id="error-box"></div>
                    <div id="modal_body"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="update()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

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
    function isType(value) {
        if (value == 1) {
            $('#parent_id').attr('style', 'display:block');
        } else {
            $('#parent_id').attr('style', 'display:none');
        }
    }

    function isTypeEdit(value, id) {
        if (value == 1) {
            $('#parent_id_' + id).attr('style', 'display:block');
        } else {
            $('#parent_id_' + id).attr('style', 'display:none');
        }
    }

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

    function edit(id) {
        var parent_data = JSON.parse('{{ $nav_parents }}'.replace(/&quot;/g, '"'));
        var data = {
            "id": id,
            "_token": "{{ csrf_token() }}"
        }
        $.ajax({
            type: "POST",
            url: '{{ url("admin/menu/edit") }}',
            data: data,
            success: function(response) {

                var child = '';
                var is_type = 'none';
                var parent = 'checked';
                if (response.is_type == 1) {
                    parent = '';
                    is_type = 'block';
                    child = 'checked';
                }

                var aStatus = '';
                var iStatus = 'selected';
                if (response.status == 1) {
                    aStatus = 'selected';
                    iStatus = '';
                }

                var common = '';
                var notice = '';
                var gallery = '';
                if (response.is_specific_page == 0) {
                    common = 'checked';
                } else if (response.is_specific_page == 1) {
                    notice = 'checked';
                } else if (response.is_specific_page == 2) {
                    gallery = 'checked';
                }

                var header = '';
                var footer = '';
                var both = '';
                if (response.is_show == 0) {
                    header = 'checked';
                } else if (response.is_show == 1) {
                    footer = 'checked';
                } else if (response.is_show == 2) {
                    both = 'checked';
                }

                var html = '';
                html += '<div class="col-md-12" id="update_form"><div class="control-group">' +
                    '<label class="control-label" for="form-field-1">Name :</label>' +
                    '<div class="controls">' +
                    '<input type="text" placeholder="name" name="name" id="edit_name" value="' + response.name + '"  onchange="editMakeSlug(this.value)">' +
                    '</div>' +
                    '</div>' +
                    '<div class="control-group">' +
                    '<label class="control-label" for="form-field-1">Slug :</label>' +
                    '<div class="controls">' +
                    '<input type="text" placeholder="Slug" name="slug" id="edit_slug" value="' + response.slug + '">' +
                    '</div>' +
                    '</div>' +
                    '<div class="control-group">' +
                    '<label class="control-label" for="form-field-1">Type :</label>' +
                    '<div class="radio">' +
                    '<label class="radio-float">' +
                    '<input type="radio" name="edit_is_type" class="ace" value="0" ' + parent + ' onclick="isTypeEdit(0,' + response.id + ')">' +
                    '<span class="lbl"> Parent</span>' +
                    '</label>' +
                    '<label class="radio-float">' +
                    '<input type="radio" name="edit_is_type" class="ace" value="1" ' + child + ' onclick="isTypeEdit(1,' + response.id + ')">' +
                    '<span class="lbl"> Child</span>' +
                    '</label>' +
                    '</div>' +
                    '</div>' +
                    '<div class="control-group" id="parent_id_' + response.id + '" style="display:' + is_type + '">' +
                    '<label class="control-label" for="form-field-2">Parent Menu :</label>' +
                    '<div class="controls">' +
                    '<select class="status" name="edit_parent_id" id="edit_parent_id">' +
                    '<option value="">Select parent Menu</option>';
                for (var i = 0; i < parent_data.length; i++) {
                    if (response.parent_id == parent_data[i].id) {
                        html += '<option value="' + parent_data[i].id + '" selected>' + parent_data[i].name + '</option>';
                    } else {
                        html += '<option value="' + parent_data[i].id + '">' + parent_data[i].name + '</option>';
                    }
                }
                html += '</select>' +
                    '</div>' +
                    '</div>' +
                    '<input type="hidden" value="' + id + '" id="update_id">'+

                    '<div class="control-group">'+
                        '<label class="control-label" for="form-field-1">Is Specific Page</label>'+
                        '<div class="radio radio-p-0">'+
                            '<label class="radio-float">'+
                                '<input type="radio" name="is_specific_page" class="ace" value="0" '+common+'>'+
                                '<span class="lbl"> Common</span>'+
                            '</label>'+
                            '<label class="radio-float">'+
                                '<input type="radio" name="is_specific_page" class="ace" value="1" '+notice+'>'+
                                '<span class="lbl"> Notice</span>'+
                            '</label>'+
                            '<label class="radio-float">'+
                                '<input type="radio" name="is_specific_page" class="ace" value="2" '+gallery+'>'+
                                '<span class="lbl"> Gallery</span>'+
                            '</label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="control-group">'+
                        '<label class="control-label" for="form-field-1">Is position</label>'+
                        '<div class="radio radio-p-0">'+
                            '<label class="radio-float">'+
                                '<input type="radio" name="is_show" class="ace" value="0" '+header+'>'+
                                '<span class="lbl"> Header Top</span>'+
                            '</label>'+
                            '<label class="radio-float">'+
                                '<input type="radio" name="is_show" class="ace" value="1" '+footer+'>'+
                                '<span class="lbl"> Footer Button</span>'+
                            '</label>'+
                            '<label class="radio-float">'+
                                '<input type="radio" name="is_show" class="ace" value="2" '+both+'>'+
                                '<span class="lbl"> Both</span>'+
                            '</label>'+
                        '</div>'+
                    '</div>'+

                    '<div class="control-group">' +
                    '<label class="control-label" for="form-field-2">Status :</label>' +
                    '<div class="controls">' +
                    '<select class="status" name="edit_status" id="edit_status">';
                html += '<option value="0" ' + iStatus + '>Inactive</option>' +
                    '<option value="1" ' + aStatus + '>Active</option>';
                html += '</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                $('#modal_body').html(html);
                $('#editModal').modal('show');
            }
        });
    }

    function update() {
        var name = $('#edit_name').val();
        var slug = $('#edit_slug').val();
        var is_type = $("#update_form input[name=edit_is_type]:checked").val();
        var parent_id = $('#edit_parent_id').val();
        var is_specific_page = $("#update_form input[name=is_specific_page]:checked").val();;
        var is_show = $("#update_form input[name=is_show]:checked").val();;
        var status = $('#edit_status').val();
        var id = $('#update_id').val();

        $('#edit_name').css('border', '1px solid #d5d5d5');
        $('#edit_slug').css('border', '1px solid #d5d5d5');
        $('#edit_parent_id').css('border', '1px solid #d5d5d5');

        if (name == "") {
            $('#edit_name').css('border', '1px solid #ff0000');
            return false;
        } else if (slug == "") {
            $('#edit_slug').css('border', '1px solid #ff0000');
            return false;
        } else if (is_type == "") {
            return false;
        } else if (is_type == 1 && parent_id == "") {
            $('#edit_parent_id').css('border', '1px solid #ff0000');
            return false;
        } else {
            var data = {
                "id": id,
                "name": name,
                "slug": slug,
                "is_type": is_type,
                "is_specific_page": is_specific_page,
                "is_show": is_show,
                "parent_id": parent_id,
                "status": status,
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                type: "POST",
                url: '{{ url("admin/menu/update") }}',
                data: data,
                success: function(response) {
                    $('#error-box').html('');
                    if (response.status == 2) {
                        $.each(response.errors, function(key, value) {
                            $('#error-box').append('<div class="alert alert-danger">' + value + '</div');
                        });
                    } else if (response.status == 3) {
                        $('#error-box').html('<div class="alert alert-danger">' + response.errors + '</div');
                    }else if (response.status == 0) {
                        $('#error-box').html('<div class="alert alert-danger">' + response.text + '</div');
                    } else if (response.status == 1) {
                        $('#error-box').html('<div class="alert alert-success">' + response.text + '</div');
                        location.reload();
                    } else {
                        $('#error-box').html('<div class="alert alert-danger">Something is worng.</div>');
                    }
                }
            });
        }
    }

    function deleteData(id) {
        bootbox.confirm({
            message: "Do you want to delete?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function(result) {
                if (result == true) {
                    $.ajax({
                        type : 'POST',
                        url : '{{ url("admin/menu/destroy") }}',
                        data : { "id": id,  "_token": "{{ csrf_token() }}" },
                        success :function(response){
                            toastr.options = { "closeButton" : true, "progressBar" : true }
                            if (response.status == 1) {
                                toastr.success(response.text);
                                location.reload();
                            } else if(response.status == 2){
                                toastr.error(response.text);
                            } else {
                                toastr.error(response.text);
                            }
                        }
                    });
                }
            }
        });
    }

    function navSort(id, isType) {
        var sortVal = $('#sort_'+id).val() !="" ? $('#sort_'+id).val() : 0;
        $.ajax({
            type: "POST",
            url: '{{ url("admin/menu/sort") }}',
            data: { "id": id, "sortVal": sortVal, "isType": isType, '_token': "{{ csrf_token() }}" },
            success: function(response){
                toastr.options = { "closeButton" : true, "progressBar" : true }
                if (response.status == 2) {
                    toastr.error(response.text);
                } else if (response.status == 1) {
                    toastr.success(response.text);
                } else {
                    toastr.error(response.text);
                }
            }
        });
    }
</script>
@endsection
