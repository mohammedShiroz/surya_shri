@extends('backend.layouts.admin')
@section('page_title','Employee')
@include('backend.components.plugins.data_table')
@section('body_content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Partners</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Partners</li>
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
                            <div class="btn-group">
                                <a href="{{ route('partners.index') }}" class="btn btn-info mr-2"><i class="fa fa-refresh mr-1"></i> Reload</a>
                                <a href="{{ route('partners.view.hierarchy') }}" class="btn btn-secondary"><i class="fa fa-eye mr-1"></i> View Hierarchy</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All Partners</h3>
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
                                @php
                                $emp_count =0;
                                function numberOfPartners($id){
                                    global $emp_count;
                                    $emp_count =0;
                                    foreach (\App\Agent::Where('placement_id',$id)->get() as $emp){
                                        $emp_count++;
                                        if($emp->child_employees->isNotEmpty()){
                                            show_emp($emp->child_employees);
                                        }
                                    }
                                    return $emp_count;
                                }
                                function show_emp($child_employees){
                                    global $emp_count;
                                    foreach($child_employees as $parent){
                                        $emp_count ++;
                                        if($parent->child_employees->isNotEmpty()){
                                            show_emp($parent->child_employees);
                                        }
                                    }
                                }
                                @endphp
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User ID & Name</th>
                                        <th>Coupon Codes</th>
                                        <th>Partner Code</th>
                                        <th>Email</th>
                                        <th>Last Activity</th>
                                        <th>Contact No</th>
                                        <th>No. of Partners</th>
                                        <th>Partner Status</th>
                                        <th>Referred User</th>
                                        <th>Placement</th>
                                        <th>Registered Date & Time</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(\App\User::whereNull('is_deleted')->where('agent_status','Approved')->get()->count()>0)
                                        @foreach(\App\User::with('employee')
                                                            ->join('agents', 'agents.user_id', '=', 'users.id')
                                                            ->where('agent_status','Approved')
                                                            ->orderBy('agents.created_at', 'DESC')
                                                            ->get()
                                        as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td>({{ $row->employee->id }}) - {{ $row->name }} {{ $row->last_name }}
                                                    @if((new DateTime($row->employee->created_at))->diff(new DateTime())->format('%a')<7)
                                                        <small class="badge badge-success text-white ml-1" style="font-size: 9px;">New</small>
                                                    @endif
                                                </td>
                                                <td>{{ ($row->user_name)? $row->user_name : '-' }}</td>
                                                <td>{{ $row->user_code }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>{{ isset($row->activity->last()->created_at)? $row->activity->last()->created_at->diffForHumans() : '-' }}</td>
                                                <td>{{ $row->contact }}</td>
                                                <td>{{ numberOfPartners($row->employee->id) }}</td>
                                                <td>@if(($row->is_doctor && $row->is_seller))
                                                        Doctor & Seller
                                                        @elseif($row->is_seller)
                                                        Seller
                                                        @elseif($row->is_doctor)
                                                        Doctor
                                                        @else
                                                        Partner
                                                    @endif
                                                </td>
                                                <td>{{ isset($row->employee->referral_info->user->name)? $row->employee->referral_info->user->name." ".$row->employee->referral_info->user->last_name : '' }}</td>
                                                <td>{{ ($row->employee->placement_id)? $row->employee->placement_info->user->name." ".$row->employee->placement_info->user->last_name : '-' }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->employee->created_at)) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('partners.show', $row->employee->user->id)}}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> Details</a>
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
@endsection
