@extends('backend.layouts.admin')
@section('page_title','Products')
@include('backend.components.plugins.data_table')
@include('backend.components.plugins.select2')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Products</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="margin" style="margin-bottom: 10px;">
                            @permission('create-products')
                            <div class="btn-group">
                                <a href="{{ route('products.create') }}" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Add a Product</a>
                            </div>
                            @endpermission
                            <div class="btn-group">
                                <a href="{{ route('products.index') }}" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                            {{--<div class="btn-group">--}}
                                {{--<button data-toggle="modal" data-target="#modal-bulk-delete"  class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Bulk Delete</button>--}}
                                {{--<form method="POST" id="delete-all-form" action="{{route('products.destroy_all')}}">--}}
                                    {{--@csrf--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Products</h3>
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
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Product Category</th>
                                        <th>Listed Price</th>
                                        <th>Available Quantity</th>
                                        <th>Seller Name & ID</th>
                                        <th>Visibility</th>
                                        <th>Added Date & Time</th>
                                        <th>Updated Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\Products::WhereNull('is_deleted')->get()->count()>0)
                                        @foreach(\App\Products::WhereNull('is_deleted')->orderby('created_at','desc')->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td width="5px">
                                                    <img class="rounded-circle" src="{{ (!empty($row->thumbnail_image)) ? asset($row->thumbnail_image) : 'http://fpae.pt/backup/20181025/wp/wp-content/plugins/post-slider-carousel/images/no-image-available-grid.jpg' }}" width="80" alt="{{ $row->name }}" />
                                                </td>
                                                <td>{{ $row->name }}
                                                    @if((new DateTime($row->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-info mt-2" style="font-size: 8px;">New</small>
                                                    @endif</td>
                                                <td>
                                                    @if(isset($row->category->parent->parent->name))
                                                        {!!  isset($row->category->parent->parent->name)? $row->category->parent->parent->name.' <strong><i class="fa fa-angle-double-right text-sm"></i></strong>': '' !!}<br/>
                                                    @endif
                                                    @if(isset($row->category->parent->name))
                                                    {{ $row->category->parent->name }} <strong><i class="fa fa-angle-double-right text-sm"></i></strong><br/>
                                                    @endif
                                                    {{ $row->category->name }}
                                                </td>
                                                <td>{{ getCurrencyFormat($row->price) }}</td>
                                                <td>{{ get_stock($row->id) }}</td>
                                                <td>({{ $row->seller_info->id }}) {{ $row->seller_info->user->name." ".$row->seller_info->user->last_name[0] }}
                                                    <small class="d-block">( {{ ($row->seller_info->is_seller && $row->seller_info->is_doctor)? ' Doctor & Seller ' : (($row->seller_info->is_doctor)? 'Doctor' : 'Seller') }})</small>
                                                </td>
                                                <td>{!! ($row->visibility == 1)? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-eye"></i> Visible</span>': '<span class="badge badge-danger pl-3 pr-3"><i class="fa fa-eye-slash"></i> Hidden</span>' !!}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->updated_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('products.show', $row->id)}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                                                        @permission('update-products')
                                                        <a href="{{ route('products.edit', $row->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                       @endpermission
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->name }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                              {{--action="{{route('products.destroy',$row->id)}}">--}}
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
                    <h4 class="modal-title">Delete Product?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> Product?
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
                    <h4 class="modal-title">Delete All Product</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete all product?</p>
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
    <form action="{{ route('admin.record.delete','products') }}" id="delete-record-form" method="POST"> @csrf</form>
@endsection
