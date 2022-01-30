@extends('backend.layouts.admin')
@section('page_title','Product categories')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.slugify')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Categories</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @permission('create-product-category')
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($edit_enabled)? 'Edit '.$data->name : 'Add a' }} Product Category</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                @if(!isset($edit_enabled))
                                <form action="{{ route('product-category.store') }}" method="post" class="form-horizontal" role="form">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-10 mb-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" checked id="visibility" name="visibility_status" >
                                                <label for="visibility">
                                                    Visible
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Category Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror name" name="name" value="{{ old('name') }}" placeholder="Category name">
                                            <input type="hidden" class="slug" name="slug" value="{{ old('name') }}" />
                                            @error('name')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Sequence</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control @error('order') is-invalid @enderror" value="{{ old('order') }}" name="order" placeholder="Sequence">
                                            @error('order')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    @else
                                    <form action="{{ route('product-category.update',$data->id) }}" method="POST" class="form-horizontal add_form" role="form">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <div class="col-sm-10 mb-3">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" {{ ($data->visibility == 1)? 'checked': '' }} id="visibility" name="visibility_status" >
                                                    <label for="visibility">
                                                        Visible
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Category Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror name" name="name" value="{{ (old('name'))? old('name'): $data->name  }}" placeholder="Category name">
                                                <input type="hidden" class="slug" name="slug" value="{{ (old('slug'))? old('slug'): $data->slug }}" />
                                                @error('name')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Sequence</label>
                                            <div class="col-sm-10">
                                                <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control @error('order') is-invalid @enderror" value="{{ (old('order'))? old('order'): $data->order }}" name="order" placeholder="Sequence">
                                                @error('order')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info float-right">Save Changes</button>
                                <button type="reset" style="margin-right:5px;" class="btn btn-secondary float-right">Reset</button>
                                <a href="{{ route('product-category.index') }}" style="margin-right:5px;" class="btn btn-danger float-right">Cancel</a>
                                </form>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                @endpermission
                <div class="row">
                    <div class="col-12">
                        <div class="margin" style="margin-bottom: 10px;">
                            @if(isset($edit_enabled))
                            <div class="btn-group">
                                <a href="{{ route('product-category.index') }}" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Add Category</a>
                            </div>
                            @endif
                            <div class="btn-group">
                                <a href="{{ route('product-category.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                            {{--<div class="btn-group">--}}
                                {{--<button data-toggle="modal" data-target="#modal-bulk-delete"  class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Bulk Delete</button>--}}
                                {{--<form method="POST" id="delete-all-form"--}}
                                      {{--action="{{route('product-category.destroy_all')}}">--}}
                                    {{--@csrf--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Product Categories</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Category Name</th>
                                        <th>Visibility</th>
                                        <th>Sequence</th>
                                        <th>Created Date & Time</th>
                                        <th>Updated Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Product_category::WhereNull('is_deleted')->whereNull('parent_id')->get()->count()>0)
                                        @foreach(\App\Product_category::WhereNull('is_deleted')->whereNull('parent_id')->orderby('created_at','desc')->get() as $k=>$row)
                                            <tr>
                                                <td width="5px">{{ $loop->index+1 }}</td>
                                                <td>{{ $row->name }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px">New</small>
                                                    @endif
                                                </td>
                                                <td>{!! ($row->visibility == 1)? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-eye"></i> Visible</span>': '<span class="badge badge-danger pl-3 pr-3"><i class="fa fa-eye-slash"></i> Hidden</span>' !!}</td>
                                                <td>{{ ($row->order == null)? 0 : $row->order }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->updated_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('product-category.show', $row->id)}}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Sub Category</a>
                                                        @permission('update-product-category')
                                                        <a href="{{ route('product-category.edit', $row->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                        @endpermission
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                              {{--action="{{route('product-category.destroy',$row->id)}}">--}}
                                                            {{--@csrf--}}
                                                            {{--@method('DELETE')--}}
                                                        {{--</form>--}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- /.content-wrapper -->
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Delete Product Category</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> category?
                        <br/><small class="text-red category-alert"></small></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-delete-now">Delete Now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.content-wrapper -->
    <div class="modal fade" id="modal-bulk-delete">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h4 class="modal-title">Delete All Product Category</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete all product categories?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-record-form').submit();">Delete All Now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <form action="{{ route('admin.record.delete','product-categories') }}" id="delete-record-form" method="POST">@csrf</form>
@endsection
