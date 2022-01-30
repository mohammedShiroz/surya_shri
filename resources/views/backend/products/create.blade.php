@extends('backend.layouts.admin')
@section('page_title','Add Products')
@include('backend.components.plugins.slugify')
@include('backend.components.plugins.select2')
@include('backend.components.plugins.dropfy')
@include('backend.components.plugins.summer_note')
@section('body_content')
    @push('css') <style> .col-form-label{ font-weight: normal !important; } </style> @endpush
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                            <li class="breadcrumb-item active">Add Products</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('products.store') }}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Product Category Details</h3>
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
                                <div class="form-group row">
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Product Category</label>
                                        <select class="form-control select2 @error('product_type') is-invalid @enderror" required name="product_type" id="category_one" style="width: 100%;">
                                            <option disabled="disabled" value="null" selected="selected">Select Product Type</option>
                                            @foreach(\App\Product_category::whereNull('parent_id')->orderby('name', 'asc')->get() as $row)
                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('product_type')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Product Sub-category</label>
                                        <select class="form-control select2 @error('item_category') is-invalid @enderror" name="item_category" id="category_two" style="width: 100%;">
                                        </select>
                                        @error('item_category')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Product Level 2 Sub-categories</label>
                                        <select class="form-control select2 @error('item_sub_category') is-invalid @enderror" name="item_sub_category" id="category_three" style="width: 100%;">
                                        </select>
                                        @error('item_sub_category')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Who does this product belongs to?</h3>
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
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Seller Name</label>
                                        <select class="form-control select2 @error('seller_id') is-invalid @enderror" required name="seller_id" style="width: 100%;">
                                            @foreach(\App\Agent::WHERENOTNULL('is_seller')->Orwhere('is_doctor','!=',null)->orderByRaw('is_seller DESC', 'is_doctor DESC')->get() as $row)
                                                <option value="{{ $row->id }}">({{ $row->id }}) - {{ $row->user->name." ".$row->user->last_name }} - ({{ ($row->is_seller && $row->is_doctor)? 'Doctor & Seller' : (($row->is_seller)? 'Seller' : 'Doctor') }})</option>
                                            @endforeach
                                        </select>
                                        @error('seller_id')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Product Details</h3>
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
                                <div class="form-group row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-sm-6 col-form-label">Product Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Item name">
                                        @error('name')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Product Code</label>
                                        <input type="text" class="form-control @error('item_code') is-invalid @enderror" name="item_code" value="{{ old('item_code') }}" placeholder="Item code">
                                        @error('item_code')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Deliverability</label>
                                        <div class="border" style="border-radius: 4px; padding: 6.5px">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" checked id="is_deliverable" name="is_deliverable_val">
                                                <label for="is_deliverable" style="font-weight: 500">Is deliverable</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Stock Availability</label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" min="0" oninput="validity.valid||(value='');" name="stock" value="{{ old('stock')? old('stock') : 0 }}" placeholder="Stock">
                                        @error('stock')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Status</label>
                                        <select class="form-control select2 @error('status') is-invalid @enderror" name="status" id="status" style="width: 100%;">
                                            <option value="DRAFTED" {{ old('status')? (old('status') == "DRAFTED") ? 'selected': '' : '' }}>Unpublished</option>
                                            <option value="PUBLISHED" {{ old('status')? (old('status') == "PUBLISHED") ? 'selected': '' : '' }} >Published</option>
                                        </select>
                                        @error('status')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Sequence</label>
                                        <input type="number" class="form-control @error('order') is-invalid @enderror" min="1" oninput="validity.valid||(value='');" value="{{ old('order')?old('order'): \App\Products::orderby('order','desc')->first()->order+1 }}" name="order" placeholder="Sequence">
                                        @error('order')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Product Visibility</label>
                                        <div class="border" style="border-radius: 4px; padding: 6px">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" {{ old('visibility_status')?  : 'checked' }} checked id="visibility" name="visibility_status" >
                                                <label for="visibility">
                                                    Visible
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Product Price Margin Details</h3>
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
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12">
                                        <p>Final Discounted Price View</p>
                                        <div class="bg-gray py-2 px-3 mb-3" style="margin-top: -10px;">
                                            <h2 class="mb-0" id="show_final_price">
                                                {{ getCurrencyFormat(0) }}
                                            </h2>
                                            <h4 class="mt-0">
                                                <del><small id="show_discount_price">{{ getCurrencyFormat(0) }}</small></del> <small><span id="show_discount_percentage">0</span>% Off</small>
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Actual price?</label>
                                        <div class="input-group mb-3">
                                            <input type="hidden" id="item_final_price" name="price" value="{{ old('price') }}">
                                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="item_price" name="actual_price" value="{{ old('actual_price') }}" placeholder="Price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('price')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Site Discount</label>
                                        <div class="input-group mb-3">
                                            <select class="form-control select2 discount_mode" name="discount_mode">
                                                <option value="none" {{ (old('discount_mode')? (old('discount_mode')== 'none')? 'selected': '' :'') }}>None</option>
                                                <option value="price" {{ (old('discount_mode')? (old('discount_mode')== 'price')? 'selected': '' :'') }}>Discounted Price</option>
                                                <option value="percentage" {{ (old('discount_mode')? (old('discount_mode')== 'percentage')? 'selected': '' :'') }}>Percentage</option>
                                            </select>
                                            <input type="text" class="form-control discount_none_el" disabled style="display: {{ (old('discount_mode')? (old('discount_mode')== 'none')? '': 'none' :'') }};">
                                            <input type="text"
                                                   style="display: {{ (old('discount_mode')? (old('discount_mode')== 'price')? '': ( (old('discount_mode')== 'percentage')? '': 'none') :'none') }};"
                                                   class="form-control @error('discount_name') is-invalid @enderror" name="discount_name" id="discount_name" value="{{ old('discount_name') }}" placeholder="Discount name">
                                            <div class="input-group-append discount_none_el" style="display: {{ (old('discount_mode')? (old('discount_mode')== 'none')? '': 'none' :'') }};">
                                                <span class="input-group-text">?</span>
                                            </div>
                                            <input style="display: {{ (old('discount_mode')? (old('discount_mode')== 'price')? '': 'none' :'none') }};" type="text" class="form-control discount_price_el @error('discount_price') is-invalid @enderror" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" placeholder="Discount price">
                                            <div class="input-group-append discount_price_el" style="display: {{ (old('discount_mode')? (old('discount_mode')== 'price')? '': 'none' :'none') }};">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                            <input type="number" min="0" max="100" style="display: {{ (old('discount_mode')? (old('discount_mode')== 'percentage')? '': 'none' :'none') }};" class="form-control maxType  discount_percentage_el @error('discount_percentage') is-invalid @enderror" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage') }}" placeholder="Discount percentage">
                                            <div class="input-group-append discount_percentage_el" style="display: {{ (old('discount_mode')? (old('discount_mode')== 'percentage')? '': 'none' :'none') }};">
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        @error('discount_price')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                        @error('discount_percentage')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Direct Partner Discount</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType direct_commission @error('direct_commission') is-invalid @enderror" name="direct_commission" value="{{ old('direct_commission') }}" placeholder="Direct commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="direct_commission_price"  readonly class="form-control direct_commission_price" value="{{ old('direct_commission_price') }}" placeholder="Direct commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('direct_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Lifetime Partner Pay Amount</label>
                                        <div class="input-group mb-3">
                                            <input type="text" name="agent_pay_amount" readonly class="form-control agent_pay_amount @error('agent_pay_amount') is-invalid @enderror" value="{{ old('agent_pay_amount') }}" placeholder="(Is partner) pay amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('agent_pay_amount')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">1st level affiliate commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control  maxType first_level_commission @error('first_level_commission') is-invalid @enderror" name="first_level_commission" value="{{ old('first_level_commission') }}" placeholder="1st level affiliate commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="first_level_commission_price" class="form-control first_level_commission_price" readonly value="{{ old('first_level_commission_price') }}" placeholder="1st level commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('first_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">2nd level affiliate commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType  second_level_commission @error('second_level_commission') is-invalid @enderror" name="second_level_commission" value="{{ old('second_level_commission') }}" placeholder="2nd level affiliate commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="second_level_commission_price" class="form-control second_level_commission_price" readonly value="{{ old('second_level_commission_price') }}" placeholder="2nd level commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('second_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">3rd level affiliate commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType  third_level_commission @error('third_level_commission') is-invalid @enderror" name="third_level_commission" value="{{ old('third_level_commission') }}" placeholder="3rd level affiliate commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" readonly name="third_level_commission_price" class="form-control third_level_commission_price"  value="{{ old('third_level_commission_price') }}" placeholder="3rd level commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('third_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">4th  level affiliate commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType  fourth_level_commission @error('fourth_level_commission') is-invalid @enderror" name="fourth_level_commission" value="{{ old('fourth_level_commission') }}" placeholder="4th level affiliate commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" readonly name="fourth_level_commission_price" class="form-control fourth_level_commission_price"  value="{{ old('fourth_level_commission_price') }}" placeholder="4th level commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('fourth_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Global commission rate</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType  fifth_level_commission @error('fifth_level_commission') is-invalid @enderror" name="fifth_level_commission" value="{{ old('fifth_level_commission') }}" placeholder="Global commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" readonly name="fifth_level_commission_price" class="form-control fifth_level_commission_price"  value="{{ old('fifth_level_commission_price') }}" placeholder="Global commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('fifth_level_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Network Bonus/Gifts</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType bonus_commission @error('bonus_commission') is-invalid @enderror" name="bonus_commission" value="{{ old('bonus_commission') }}" placeholder="Bonus commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="bonus_commission_price" class="form-control bonus_commission_price" readonly value="{{ old('bonus_commission_price') }}" placeholder="Bonus commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('bonus_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Site account (expenses& profit)</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType expenses_commission @error('expenses_commission') is-invalid @enderror" name="expenses_commission" value="{{ old('expenses_commission') }}" placeholder="Expenses commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="expenses_commission_price" class="form-control expenses_commission_price" readonly value="{{ old('expenses_commission_price') }}" placeholder="Expenses commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('expenses_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Donations</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType donations_commission @error('donations_commission') is-invalid @enderror" name="donations_commission" value="{{ old('donations_commission') }}" placeholder="Donations commission">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="donations_commission_price" class="form-control donations_commission_price" readonly value="{{ old('donations_commission_price') }}" placeholder="Donations commission price">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('donations_commission')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="inputEmail3" class="col-form-label">Seller earning</label>
                                        <div class="input-group mb-3">
                                            <input type="number" min="0" oninput="validity.valid||(value='');" class="form-control maxType seller_paid @error('seller_paid') is-invalid @enderror" readonly name="seller_paid" value="100" placeholder="To seller pay rate">
                                            <div class="input-group-append mr-3">
                                                <span class="input-group-text">%</span>
                                            </div>
                                            <input type="text" name="seller_paid_amount" class="form-control seller_paid_amount" readonly value="{{ old('seller_paid_amount') }}" placeholder="Seller paid amount">
                                            <div class="input-group-append">
                                                <span class="input-group-text">LKR</span>
                                            </div>
                                        </div>
                                        @error('seller_paid')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Product Image</h3>
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
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12">
                                        <input type="file"
                                               name="image"
                                               id="image"
                                               class="dropify"
                                               data-min-width="540"
                                               data-min-height="600"
                                               {{--data-max-width="1000"--}}
                                               {{--data-max-height="1000"--}}
                                               data-allowed-file-extensions="jpeg jpg png gif"
                                               data-max-file-size="3M"
                                               data-max-file-size-preview="3M"
                                               {{--data-allowed-formats="portrait square"--}}
                                               data-errors-position="outside"
                                               data-show-errors="true"
                                               data-show-loader="true"
                                               data-show-remove="true"
                                        />
                                        @error('image')
                                        <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                            <!-- /.card -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Product Description</h3>
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
                                    <div class="form-group row">
                                        <div class="col-md-12 col-sm-12">
                                            <label for="inputEmail3" class="col-form-label">Small Description</label>
                                            <textarea class="form-control" name="description" rows="5" placeholder="Small Description">{{ old('description')? old('description'): '' }}</textarea>
                                            @error('description')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-sm-12 mt-2">
                                            <label for="inputEmail3" class="col-form-label">Long Description</label>
                                            <textarea class="form-control" id="summernote" name="long_description" rows="5">{!! old('long_description')? old('long_description'): '' !!}</textarea>
                                            @error('long_description')
                                                <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 col-sm-12 mt-2">
                                            <label for="inputEmail3" class="col-form-label">Additional</label>
                                            <textarea class="form-control" id="summernote" name="additional" rows="5">{!! old('additional')? old('additional'): '' !!}</textarea>
                                            @error('additional')
                                            <div class="form-control-feedback text-danger text-sm">{{$message}}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 pull-right">
                                            <a href="" class="btn btn-primary btn-flat"><i class="fa fa-refresh"></i> Reset</a>
                                            <button type="submit" class="btn btn-info btn-flat"><i class="fa fa-check-circle"></i> Save Changes</button>
                                            <a href="{{ route('products.index') }}" class="btn btn-danger btn-flat"><i class="fa fa-arrow-circle-left"></i> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </form>
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
@push('script')
    <script>
        $('#category_one').on('change', function () {
            Get_category_name(this.value, '{{route('products.category.two')}}', '#category_two');
        });
        $('#category_two').on('change', function () {
            Get_category_name(this.value, '{{route('products.category.three')}}', '#category_three');
        });
        function Get_category_name(selected_value, url, data_fetch_id) {
            $.ajax({
                url: url,
                type: "POST",
                data: {
                    id: selected_value,
                    _token: '{{ csrf_token()}}',
                },
                cache: true,
                success: function (data) {
                    $(data_fetch_id).html('');
                    $("#category_three").html('');
                    $(data_fetch_id).append(data);
                }
            });
        }
    </script>
@endpush
@push('script')
    <script>
        $(document).keypress(
            function(event){
                if (event.which == '13') { event.preventDefault(); }
            });
        $('#item_price').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $('#discount_price').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $("#item_price").on("input", function(){ set_commissions(); });
        $(".discount_mode").on("change", function(){
            var value = $(this).children("option:selected").val();
            if(value == "price"){
                $(".discount_none_el").hide(); $(".discount_price_el").show(); $(".discount_percentage_el").hide(); $("#discount_name").show();
            }else if(value == "percentage"){
                $(".discount_none_el").hide(); $(".discount_price_el").hide(); $(".discount_percentage_el").show(); $("#discount_name").show();
            }else{
                $("#discount_name").hide(); $("#discount_name").val('');
                var item_pr=0;
                if($("#item_price").val()){ item_pr=$("#item_price").val(); }
                $(".discount_none_el").show(); $(".discount_price_el").hide();
                $(".discount_percentage_el").hide(); $("#show_final_price").html(formatAmount(item_pr));
                $("#item_final_price").val(item_pr.toFixed(2)); $(".agent_pay_amount").val(item_pr.toFixed(2));
                $("#show_discount_price").html(formatAmount(0)); $("#discount_price").val(null);
                $("#show_discount_percentage").html(0); $("#discount_percentage").val(null); set_commissions();
            }
        });
        $("#discount_percentage").on("input", function(){ set_commissions(); });
        $("#discount_price").on("input", function(){ set_commissions(); });
        function set_commissions(){
            var actual_price = $("#item_price").val();
            var discount_mode = $(".discount_mode").children("option:selected").val();
            var discount_price = $("#discount_price").val();
            var discount_percentage = $("#discount_percentage").val();
            var direct_commission = $(".direct_commission").val();
            var first_level_commission = $(".first_level_commission").val();
            var second_level_commission = $(".second_level_commission").val();
            var third_level_commission = $(".third_level_commission").val();
            var fourth_level_commission = $(".fourth_level_commission").val();
            var fifth_level_commission = $(".fifth_level_commission").val();
            var bonus_commission =  $(".bonus_commission").val();
            var expenses_commission = $(".expenses_commission").val();
            var donations_commission = $(".donations_commission").val();
            var seller_paid = $(".seller_paid").val();

            if($("#item_price").val()){
                if(discount_mode == 'price'){
                    if(discount_price){
                        $("#show_final_price").html(formatAmount(discount_price));
                        $("#item_final_price").val(discount_price);
                        $(".agent_pay_amount").val(discount_price);
                        $("#show_discount_price").html(formatAmount(actual_price));
                        var cal_discount_percentage = ((parseFloat(actual_price) - parseFloat(discount_price)) * 100) / parseFloat(actual_price);
                        if (cal_discount_percentage < 0) { cal_discount_percentage =0; }
                        $("#discount_percentage").val(cal_discount_percentage.toFixed(0));
                        $("#show_discount_percentage").html(cal_discount_percentage.toFixed(0));
                    }else{
                        $("#show_final_price").html(formatAmount(actual_price));
                        $("#item_final_price").val(actual_price); $(".agent_pay_amount").val(actual_price);
                        $("#show_discount_price").html(formatAmount(0)); $("#discount_percentage").val(0); $("#show_discount_percentage").html(0);
                    }
                }else if(discount_mode == 'percentage'){
                    var cal_final_price = (parseFloat(actual_price) - ((discount_percentage / 100) * parseFloat(actual_price)));
                    $("#show_final_price").html(formatAmount(cal_final_price)); $("#item_final_price").val(cal_final_price);
                    $("#show_discount_price").html(formatAmount(actual_price)); $(".agent_pay_amount").val(cal_final_price);
                    $("#discount_price").val(cal_final_price); $("#show_discount_percentage").html(discount_percentage);
                }else{
                    $("#show_final_price").html(formatAmount(actual_price)); $("#item_final_price").val(actual_price); $(".agent_pay_amount").val(actual_price);
                }
                if(direct_commission){
                    var discount_direct_price = (((direct_commission / 100) * $("#item_final_price").val()));
                    $(".direct_commission_price").val(discount_direct_price.toFixed(2));
                    $(".agent_pay_amount").val(($("#item_final_price").val()-discount_direct_price).toFixed(2));
                }
                if(first_level_commission){  $(".first_level_commission_price").val((((first_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(second_level_commission){ $(".second_level_commission_price").val((((second_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2));}
                if(third_level_commission){ $(".third_level_commission_price").val((((third_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(fourth_level_commission){ $(".fourth_level_commission_price").val((((fourth_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(fifth_level_commission){ $(".fifth_level_commission_price").val((((fifth_level_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(bonus_commission){ $(".bonus_commission_price").val((((bonus_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(expenses_commission){ $(".expenses_commission_price").val((((expenses_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(donations_commission){ $(".donations_commission_price").val((((donations_commission / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                if(seller_paid){ $(".seller_paid_amount").val((((seller_paid / 100) * $(".agent_pay_amount").val())).toFixed(2)); }
                set_seller_percentage();
            }else{
                $("#show_final_price").html(formatAmount(0)); $("#item_final_price").val(0);
                $("#show_discount_price").html(formatAmount(0)); $(".agent_pay_amount").val(0);
                $("#show_discount_percentage").html(0);  $(".direct_commission_price").val(null);
                $(".first_level_commission_price").val(null); $(".second_level_commission_price").val(null);
                $(".third_level_commission_price").val(null); $(".fourth_level_commission_price").val(null);
                $(".fifth_level_commission_price").val(null);  $(".bonus_commission_price").val(null);
                $(".expenses_commission_price").val(null); $(".donations_commission").val(null); $(".seller_paid_amount").val(null);
                set_seller_percentage();
            }
        }
        $(".direct_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $("#item_final_price").val()));
                        $(".direct_commission_price").val(discount_price.toFixed(2));
                        $(".agent_pay_amount").val(($("#item_final_price").val()-discount_price).toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".direct_commission_price").val(null); $(".agent_pay_amount").val($("#item_final_price").val()); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".first_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".first_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".first_level_commission_price").val(null); }
                set_seller_percentage();
            }else{  alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".second_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".second_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".second_level_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".third_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".third_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".third_level_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".fourth_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".fourth_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".fourth_level_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".fifth_level_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".fifth_level_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".fifith_level_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".bonus_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".bonus_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".bonus_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".expenses_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".expenses_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".expenses_commission_price").val(null); }
                set_seller_percentage();
            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".donations_commission").on("input", function(event){
            if($("#item_price").val()) {
                if ($(this).val() != '') {
                    if(set_seller_percentage() <= 100){
                        var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
                        $(".donations_commission_price").val(discount_price.toFixed(2));
                    }else{
                        event.preventDefault();
                        $(this).val($(this).val().substr(0,($(this).val().length -1)));
                    }
                } else { $(".donations_commission_price").val(null); }
                set_seller_percentage();

            }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        $(".seller_paid").on("input", function(){
            // if($("#item_price").val()) {
            //     if ($(this).val() != '') {
            //         var discount_price = ((($(this).val() / 100) * $(".agent_pay_amount").val()));
            //     } else { $(".seller_paid_amount").val(null); }
            // }else{ alert('Please enter product price first.'); $(this).val(null); }
        });
        function formatAmount(number,text ,decPlaces, decSep, thouSep) {
            decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
                decSep = typeof decSep === "undefined" ? "." : decSep;
            thouSep = typeof thouSep === "undefined" ? "," : thouSep;
            var sign = number < 0 ? "-" : "";
            var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
            var j = (j = i.length) > 3 ? j % 3 : 0;
            if(!text){ text="LKR. "; }
            return text+ sign +
                (j ? i.substr(0, j) + thouSep : "") +
                i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
                (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
        }
        $(".maxType").keypress(function(event){ if(parseInt($(this).val()+String.fromCharCode(event.which)) > 100){ return false; }else{ return true; } });
        function set_seller_percentage(){
            var per_total=0;
            var per_price =0;
            if($(".direct_commission").val()){
                // per_total += parseInt($(".direct_commission").val());
            }
            if($(".first_level_commission").val()){
                per_total += parseInt($(".first_level_commission").val());
                per_price += parseFloat($(".first_level_commission_price").val());
            }
            if($(".second_level_commission").val()){
                per_total += parseInt($(".second_level_commission").val());
                per_price += parseFloat($(".second_level_commission_price").val());
            }
            if($(".third_level_commission").val()){
                per_total += parseInt($(".third_level_commission").val());
                per_price += parseFloat($(".third_level_commission_price").val());
            }
            if($(".fourth_level_commission").val()){
                per_total += parseInt($(".fourth_level_commission").val());
                per_price += parseFloat($(".fourth_level_commission_price").val());
            }
            if($(".fifth_level_commission").val()){
                per_total += parseInt($(".fifth_level_commission").val());
                per_price += parseFloat($(".fifth_level_commission_price").val());
            }
            if($(".bonus_commission").val()){
                per_total += parseInt($(".bonus_commission").val());
                per_price += parseFloat($(".bonus_commission_price").val());
            }
            if($(".expenses_commission").val()){
                per_total += parseInt($(".expenses_commission").val());
                per_price += parseFloat($(".expenses_commission_price").val());
            }
            if($(".donations_commission").val()){
                per_total += parseInt($(".donations_commission").val());
                per_price += parseFloat($(".donations_commission_price").val());
            }
            if(per_total <= 100){
                $(".seller_paid_amount").val(($(".agent_pay_amount").val() - per_price));
                $(".seller_paid").val(100-per_total);
            }else{
                alert('You can\'t enter more than 100%.');
            }

            return per_total;
        }
    </script>
@endpush
