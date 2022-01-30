@extends('backend.layouts.admin')
@section('page_title','Question Details')
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
                    <h1>Question Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('questions.index') }}">Questions</a></li>
                        <li class="breadcrumb-item active">View question details</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{--<div class="callout callout-info">--}}
                        {{--<h5><strong><i class="fa fa-tags pr-2"></i> Question Type:</strong> {{ $data->category->name }}</h5>--}}
                    {{--</div>--}}
                    <div class="callout callout-info">
                        <h5><i class="fa fa-question-circle-o pr-2"></i> Question</h5>
                        <strong>{{ $data->question }}</strong>
                    </div>
                    <div class="callout callout-info">
                        <h5><i class="fa fa-eye pr-2"></i> Visibility</h5>
                        {!! ($data->visibility == 1)? '<span class="badge badge-success pl-3 pr-3">Visible</span>': '<span class="badge badge-danger pl-3 pr-3">Hidden</span>' !!}
                    </div>
                    <div class="callout callout-info">
                        <h5><i class="fa fa-list-alt pr-2"></i> Rank </h5>
                        <strong>{{ ($data->order == null)? 0 : $data->order }}</strong>
                    </div>
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        @permission('create-answers')
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas {{ isset($edit_enabled)? 'fa-edit' : 'fa-plus-circle' }} "></i> {{ isset($edit_enabled)? 'Edit '.$data->name : 'Add' }} Answers
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="card-body">
                            @if(!isset($edit_enabled))
                                <form action="{{ route('answers.store') }}" method="post" class="form-horizontal" role="form">
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
                                    <div class="form-group row d-none">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Answer type</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2 @error('type') is-invalid @enderror" name="type" style="width: 100%;">
                                                <option value="Vata" {{ (old('type'))? ((old('type') == 'Vata')? 'selected': '') : '' }}>Vāta</option>
                                                <option value="Pitta" {{ (old('type'))? ((old('type') == 'Pitta')? 'selected': '') : '' }}>Pitta</option>
                                                <option value="Kapha" {{ (old('type'))? ((old('type') == 'Kapha')? 'selected': '') : '' }}>Kapha</option>
                                            </select>
                                            @error('type') <div class="form-control-feedback text-danger text-sm">{{$message}}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Answer</label>
                                        <div class="col-sm-10">
                                            <input type="hidden" name="question_id" value="{{ $data->id }}" />
                                            <input type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" value="{{ old('answer') }}" placeholder="Answer">
                                            @error('answer')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Rank</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control @error('order') is-invalid @enderror name" value="{{ old('order') }}" name="order" placeholder="Rank">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info float-right">Save Changes</button>
                                    <button type="reset" style="margin-right:5px;" class="btn btn-secondary float-right">Reset</button>
                                </form>
                            @else
                                <form action="{{ route('answers.update',$data_answer->id) }}" method="POST" class="form-horizontal" role="form">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <div class="col-sm-10 mb-3">
                                            <div class="icheck-primary d-inline">
                                                <input type="hidden" name="question_id" value="{{ $data->id }}" />
                                                <input type="checkbox" {{ ($data_answer->visibility == 1)? 'checked': '' }} id="visibility_status" name="visibility_status" >
                                                <label for="visibility_status">
                                                    Visible
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row d-none">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Answer type</label>
                                        <div class="col-sm-10">
                                            <select class="form-control select2 @error('type') is-invalid @enderror" name="type" style="width: 100%;">
                                                <option value="Vata" {{ (old('type'))? ((old('type') == 'Vata')? 'selected': '') : (($data_answer->type == 'Vata')? 'selected': '') }}>Vāta</option>
                                                <option value="Pitta" {{ (old('type'))? ((old('type') == 'Pitta')? 'selected': '') : (($data_answer->type == 'Pitta')? 'selected': '') }}>Pitta</option>
                                                <option value="Kapha" {{ (old('type'))? ((old('type') == 'Kapha')? 'selected': '') : (($data_answer->type == 'Kapha')? 'selected': '') }}>Kapha</option>
                                            </select>
                                            @error('type') <div class="form-control-feedback text-danger text-sm">{{$message}}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Answer</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" value="{{ (old('answer'))? old('answer'): $data_answer->answer }}" placeholder="Answer">
                                            @error('answer')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Rank</label>
                                        <div class="col-sm-10">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control @error('order') is-invalid @enderror" value="{{ (old('order'))? old('order'): $data_answer->order }}" name="order" placeholder="Rank">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info float-right">Save Changes</button>
                                    <button type="reset" style="margin-right:5px;" class="btn btn-secondary float-right">Reset</button>
                                    <a href="{{ route('questions.show',$data->id) }}" style="margin-right:5px;" class="btn btn-danger float-right">Cancel</a>
                                </form>
                            @endif
                        </div>
                        @endpermission
                        @permission('read-answers')
                        <!-- /.card-body -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-info-circle"></i> All Answers
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
                                        <th>Answer</th>
                                        <th>Type</th>
                                        <th>Rank</th>
                                        <th>Visibility</th>
                                        <th>Created Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $alpha=array('A','B','C','D','E','F','G','H','I','J','k','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z') ;?>
                                    @if($data->answers->count() > 0)
                                        @foreach($data->answers as $k=>$row)
                                            <tr>
                                                <td width="5px">{{ $alpha[$k] }}</td>
                                                <td>{{ $row->answer }}</td>
                                                <td>
                                                    @if($alpha[$k] == "A") Vata
                                                    @elseif($alpha[$k] == "B") Pitta
                                                    @elseif($alpha[$k] == "C") Kapha
                                                    @endif
                                                </td>
                                                <td>{{ ($row->order == null)? 0 : $row->order }}</td>
                                                <td>{!! ($row->visibility == 1)? '<span class="badge badge-success pl-3 pr-3"><i class="fa fa-eye"></i> Visible</span>': '<span class="badge badge-danger pl-3 pr-3"><i class="fa fa-eye-slash"></i> Hidden</span>' !!}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        @permission('update-answers')
                                                        <a href="{{ route('answers.edited', [$data->id,$row->id])}}" class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                        @endpermission
                                                        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete" onclick="delete_data('{{ $row->id }}','{{ $row->answer }}')"><i class="fas fa-trash"></i></button>--}}
                                                        {{--<form method="POST" id="{{'delete-form-'.$row->id}}"--}}
                                                              {{--action="{{route('answers.destroy',$row->id)}}">--}}
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
                        @endpermission
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
                    <h4 class="modal-title">Delete Answer?</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are sure want to delete <b><span id="tag_name"></span></b> Answer?
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
