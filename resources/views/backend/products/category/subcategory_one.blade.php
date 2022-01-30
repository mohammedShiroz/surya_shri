@extends('backend.layouts.admin')
@section('page_title','Product Category Detail')
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
                        <h3>{{ $data->name }} - Product Category Detail</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('product-category.index') }}">Product Categories</a></li>
                            <li class="breadcrumb-item active">View &nbsp;<b>{{ $data->name }}</b>&nbsp; Category Details</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-3">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-tags pr-2"></i> Category Level</h5>
                            <strong>First Category</strong>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-question-circle-o pr-2"></i> Category Name</h5>
                            <strong>{{ $data->name }}</strong>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-eye pr-2"></i> Visibility</h5>
                            {!! ($data->visibility == 1)? '<span class="badge badge-success pl-3 pr-3">Visible</span>': '<span class="badge badge-danger pl-3 pr-3">Hidden</span>' !!}
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="callout callout-info">
                            <h5><i class="fa fa-list-alt pr-2"></i> Sequence</h5>
                            <strong>{{ ($data->order == null)? 0 : $data->order }}</strong>
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas {{ isset($edit_enabled)? 'fa-edit' : 'fa-plus-circle' }} "></i> {{ isset($edit_enabled)? 'Edit '.$data->name.'\'s '.$data_two->name : 'Add a '.$data->name.'\'s' }} Sub-Category
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="card-body">
                                @if(!isset($edit_enabled))
                                    <form action="{{ route('product-category.sub-category.store') }}" method="post" class="form-horizontal" role="form">
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
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Sub Category Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror name" name="name" value="{{ old('name') }}" placeholder="Category name">
                                                <input type="hidden" class="slug" name="slug" value="{{ old('name') }}" />
                                                <input type="hidden" name="parent_id" value="{{ $data->id }}" />
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
                                        <button type="submit" class="btn btn-info float-right">Save Changes</button>
                                        <button type="reset" style="margin-right:5px;" class="btn btn-secondary float-right">Reset</button>
                                    </form>
                                @else
                                    <form action="{{ route('product-category.sub-category.update',$data_two->id) }}" method="POST" class="form-horizontal" role="form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_category_two" value="true" />
                                        <div class="form-group row">
                                            <div class="col-sm-10 mb-3">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" {{ ($data_two->visibility == 1)? 'checked': '' }} id="visibility" name="visibility_status" >
                                                    <label for="visibility">
                                                        Visible
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Sub Category Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror name" name="name" value="{{ (old('name'))? old('name'): $data_two->name  }}" placeholder="Category name">
                                                <input type="hidden" class="slug" name="slug" value="{{ (old('slug'))? old('slug'): $data_two->slug }}" />
                                                <input type="hidden" name="parent_id" value="{{ $data->id }}" />
                                                @error('name')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Sequence</label>
                                            <div class="col-sm-10">
                                                <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control @error('order') is-invalid @enderror" value="{{ (old('order'))? old('order'): $data_two->order }}" name="order" placeholder="Sequence">
                                                @error('order')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-info float-right">Save Changes</button>
                                        <button type="reset" style="margin-right:5px;" class="btn btn-secondary float-right">Reset</button>
                                        <a href="{{ route('product-category.show',$data->id) }}" style="margin-right:5px;" class="btn btn-danger float-right">Cancel</a>
                                    </form>
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <i class="fas fa-tags"></i> All {{ $data->name }}'s Sub-Categories
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
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
                                        @if($data->children->count() > 0)
                                            @foreach($data->children as $k=>$row)
                                                <tr>
                                                    <td width="5px">{{ $loop->index+1  }}</td>
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
                                                            <a href="{{ route('product-category.show_third_category', [ $data->id, $row->id])}}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add L2 Sub-category</a>
                                                            @permission('update-product-category')
                                                            <a href="{{ route('product-category.sub_edit', [$data->id, $row->id,])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
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
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
        <!-- /.content-wrapper -->
        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title">Delete {{ $data->name }}'s Sub-Category?</h4>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are sure want to delete <b><span id="tag_name"></span></b> {{ $data->name }}'s sub-category?
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
    </div>
@endsection
