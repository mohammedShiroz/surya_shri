@extends('administration.layouts.admin')
@section('head_section')
    @include('administration.components.head_elements')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('administration/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
          href="{{ asset('administration/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet"
          href="{{ asset('administration/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection
@section('body_content')
    @include('administration.components.top_navigation')
    @include('administration.components.left_navigation')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Second Categories</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li class="breadcrumb-item active">Second Categories</li>
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
                            @if(isset($add_page) or isset($edit_page))
                                <div class="btn-group">
                                    <a href="{{ url('bay-admin/last-categories')}}"
                                       class="btn btn-success btn-block"><i class="fa fa-long-arrow-left"></i> Back</a>
                                </div>
                            @else
                                <div class="btn-group">
                                    <a href="{{ url('bay-admin/last-categories/create')}}"
                                       class="btn btn-success btn-block"><i class="fa fa-plus"></i> Add</a>
                                </div>
                            @endif
                            <div class="btn-group">
                                <a href="" class="btn btn-info btn-block"><i class="fa fa-refresh"></i> Reload</a>
                            </div>
                            <div class="btn-group">
                                <button data-toggle="modal" data-target="#modal-bulk-delete"
                                        class="btn btn-danger btn-block"><i class="fa fa-trash"></i> Bulk Delete
                                </button>
                            </div>
                        </div>
                        @if(isset($add_page))
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Add Category</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                {!! Form::open(['action' => 'MainCategoryController@store_last_category', 'class' => 'form-horizontal','role' => 'form', 'method' => 'POST']) !!}
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Sub Category</label>
                                                <select name="sub_cat" class="form-control">
                                                    @if(count($sub_categories)>0)
                                                        @foreach($sub_categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input type="text" class="form-control cat_name" name="cat_name"
                                                       placeholder="Category name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Category Slug</label>
                                                <input type="text" class="form-control cat_slug" name="slug"
                                                       placeholder="Slug">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Save & Changes</button>
                                    <button type="reset" style="margin-right:5px;"
                                            class="btn btn-secondary float-right">Reset
                                    </button>
                                    <a href="{{ url('bay-admin/last-categories/')}}" style="margin-right:5px;"
                                       class="btn btn-danger float-right">Cancel</a>
                                </div>
                                <!-- /.card-footer -->
                                {!! Form::close() !!}
                            </div>
                            <!-- /.card -->
                        @elseif(isset($edit_page))
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Category</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                {!! Form::open(['action' => ['MainCategoryController@update_last_category',$category->id], 'class' => 'form-horizontal','role' => 'form', 'method' => 'POST']) !!}
                                {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Parent Category</label>
                                                <select name="sub_cat" class="form-control">
                                                    @if(count($sub_categories)>0)
                                                        @foreach($sub_categories as $cat)
                                                            <option value="{{ $cat->id }}" <?php if($cat->id == $category->parent->id){ echo "selected"; } ?>>{{ $cat->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Category Name</label>
                                                <input type="text" class="form-control cat_name" value="{{ $category->name }}" name="cat_name"
                                                       placeholder="Category name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <!-- text input -->
                                            <div class="form-group">
                                                <label>Category Slug</label>
                                                <input type="text" class="form-control cat_slug" value="{{ $category->slug }}" name="slug"
                                                       placeholder="Slug">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info float-right">Save & Changes</button>
                                    <button type="reset" style="margin-right:5px;"
                                            class="btn btn-secondary float-right">Reset
                                    </button>
                                    <a href="{{ url('bay-admin/sub-categories/')}}" style="margin-right:5px;"
                                       class="btn btn-danger float-right">Cancel</a>
                                </div>
                                <!-- /.card-footer -->
                                {!! Form::close() !!}
                            </div>
                            <!-- /.card -->
                        @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Second Categories</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Last Category Name</th>
                                        <th>Sub Category Name</th>
                                        <th>Category Name</th>
                                        <th>Created Date & Time</th>
                                        <th>Updated Date & Time</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($categories)>0)
                                        @foreach($categories as $category)
                                            <tr>
                                                <td width="5px">{{ $category->id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->parent->name }}</td>
                                                <td>{{ $category->parent->parent->name }}</td>
                                                <td>{{ $category->created_at }}</td>
                                                <td>{{ $category->updated_at }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ url('bay-admin/last-categories/'.$category->id.'/edit') }}"
                                                           class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                                                data-target="#modal-delete"
                                                                onclick="delete_data('{{ $category->id }}','{{ $category->name }}')">
                                                            <i class="fas fa-trash"></i></button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Last Category Name</th>
                                            <th>Sub Category Name</th>
                                            <th>Category Name</th>
                                            <th>Created Date & Time</th>
                                            <th>Updated Date & Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
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
                    <h4 class="modal-title">Delete Sub Category</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> sub category?
                        <br/>
                        <small class="text-red category-alert"></small>
                    </p>

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
                    <h4 class="modal-title">Delete All Last Categories</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete all last categories?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-delete-all-now">Delete All Now</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('script_section')
    @include('administration.components.footer_script')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('administration/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('administration/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        $(".cat_name").on("input", function () {
            console.log('hi');
            $(".cat_slug").val(slugify($(this).val()));
        });

        function slugify(string) {
            const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
            const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
            const p = new RegExp(a.split('').join('|'), 'g')
            return string.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
                .replace(/&/g, '-and-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '')
        }

        var get_id;
        function delete_data(id, title) {
            get_id = id;
            document.getElementById("tag_name").innerHTML = title;
            $.ajax({
                url: "/bay-admin/categories/delete/fetch_data/" + get_id,
                method: "GET",
                data: {},
                success: function (data) {
                    if (data.length > 2) {
                        var warn_msg = "Make sure these sub category/s also belongs to this category. This will be also will delete.";
                        $(".category-alert").html(data + "<br/>" + warn_msg);
                    }
                    else {
                        $(".category-alert").html('');
                    }
                }
            });
        }

        $(function () {
            $(".btn-delete-now").on('click', function (e) {
                location.href = '/bay-admin/last-categories/delete/' + get_id;
            });

            $(".btn-delete-all-now").on('click', function (e) {
                location.href = '/bay-admin/last-categories/delete/all/bulk-delete';
            });
        });
    </script>
@endsection