@extends('layouts.admin.layer')
@section('title', 'Category Add | Salik & Co Blog')
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
        <li class="active">Category Add</li>
    </ul>
    <!--.breadcrumb-->
</div>

<div class="page-content">
    <div class="page-header position-relative">
        <h1>Category Add</h1>
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
            <form action="{{ route('admin.categories.store') }}" accept-charset="utf-8" method="post" class="form-horizontal" enctype="multipart/form-data">
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
                    <th class="hidden-480">status</th>
                    <th class="hidden-480">Sort</th>
                    <th>Created at</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php $count = 1; @endphp
                @forelse($records as $val)
                <tr>
                    <td>{{ $count }}</td>
                    <td>{{ $val->name }}</td>
                    <td>{{ $val->slug }}</td>
                    <td>{!! $val->status == 1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
                    <td>
                        <input type="text" id="sort_{{$val->id}}" class="nav-sort" value="{{ $val->sort }}" onchange="navSort({{ $val->id }})">

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
        var data = {
            "id": id,
            "_token": "{{ csrf_token() }}"
        }
        $.ajax({
            type: "POST",
            url: '{{ url("admin/categories/edit") }}',
            data: data,
            success: function(response) {

                var aStatus = '';
                var iStatus = 'selected';
                if (response.status == 1) {
                    aStatus = 'selected';
                    iStatus = '';
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
                    '<input type="hidden" value="' + id + '" id="update_id">'+
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
        var status = $('#edit_status').val();
        var id = $('#update_id').val();

        $('#edit_name').css('border', '1px solid #d5d5d5');
        $('#edit_slug').css('border', '1px solid #d5d5d5');

        if (name == "") {
            $('#edit_name').css('border', '1px solid #ff0000');
            return false;
        } else if (slug == "") {
            $('#edit_slug').css('border', '1px solid #ff0000');
            return false;
        }else {
            var data = {
                "id": id,
                "name": name,
                "slug": slug,
                "status": status,
                "_token": "{{ csrf_token() }}"
            }
            $.ajax({
                type: "POST",
                url: '{{ url("admin/categories/update") }}',
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
                        url : '{{ url("admin/categories/destroy") }}',
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

    function navSort(id) {
        var sortVal = $('#sort_'+id).val() !="" ? $('#sort_'+id).val() : 0;
        $.ajax({
            type: "POST",
            url: '{{ url("admin/categories/sort") }}',
            data: { "id": id, "sortVal": sortVal, '_token': "{{ csrf_token() }}" },
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
