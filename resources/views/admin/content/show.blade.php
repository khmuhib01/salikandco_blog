@extends('layouts.admin.layer')
@section('title', 'Content Lists | Boston Admin Panel')
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
        <li class="active">Content Lists</li>
    </ul>
    <!--.breadcrumb-->
</div>

<div class="page-content">
    <div class="page-header position-relative">
        <h1>Content Lists</h1>
    </div>
    <!--/.page-header-->

    <div class="row-fluid">
        <div class="table-header">
            Results for "Content List"
            <span class="text-muted pull-right show-count">Showing {{$records->currentPage()*$records->perPage()-$records->perPage()+1}} to {{ ($records->currentPage()*$records->perPage()>$records->total())?$records->total():$records->currentPage()*$records->perPage()}} of {{$records->total()}} data(s)</span>
        </div>

        <div class="search-box pull-right">
            <form action="{{ url('admin/content/show') }}" method="get">
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
                    <th class="hidden-480">Category Name</th>
                    <th class="hidden-480">Title</th>
                    <th class="hidden-480">Image</th>
                    <th class="hidden-480">status</th>
                    <th>Created at</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @php $count = 1; @endphp
                @forelse($records as $val)
                    @php 
                        $staus = '<span class="badge badge-danger">Draft</span>';
                        if ($val->status == 'publish') :
                            $staus = '<span class="badge badge-success">Publish</span>';
                        elseif ($val->status == 'private') :
                            $staus = '<span class="badge badge-danger">private</span>';
                        endif 
                    @endphp
                <tr>
                    <td>{{ $count }}</td>
                    <td>{{ getCategoryName($val->categories_id) }}</td>
                    <td>{{ $val->title }}</td>
                    @if ($val->image !="")
                        <td><img src="{{ url('public/storage/image/post_image/thumbnail/small/'.$val->image) }}" alt="post-image-{{ $val->categories_id }}"></td>
                    @else
                        <td><img src="{{ url('public/storage/image/no-image.png') }}" alt="no-image" style="width: 100px; hight:100px;"></td>
                    @endif
                    <td>{!! $staus !!}</td>
                    <td>{{ $val->created_at }}</td>
                    <td>
                        <a href="{{ url('admin/content/'.$val->id.'/edit') }}">Edit</a>
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
                        url : '{{ url("admin/content/destroy") }}',
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
</script>

@endsection
