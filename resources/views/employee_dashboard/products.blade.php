@extends('layouts.front')
@section('page_title','My Products')
@section('seo_contents', view('components.general.seo_meta',
[ 'm_title' => __('My Products'),
  'm_description' => 'About Surya Sri Ayurweda.',
  'm_keywords' => 'Surya Sri Ayurweda, Ayurweda',
  'm_abstract' => 'About Surya Sri Ayurweda.']))
@include('backend.components.plugins.data_table_front')
@section('body_content')
    @yield('breadcrumb',view('components.breadcrumb',['page_title_text'=>'My Products','paths'=>[
        0=>['name'=>'<i class="fa fa-home fa-sm"></i>Home','route'=>route('home')],
        1=>['name'=>'Dashboard','route'=>route('dashboard')],
        2=>['name'=>'Partner','route'=>route('partners.profile')],
        3=>['name'=>'My Products','route'=>''],
    ]]))
    <!-- START MAIN CONTENT -->
    <div class="main_content step_up">
        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4">
                        @include('employee_dashboard.nav.index')
                    </div>
                    <div class="col-lg-9 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-uppercase">My products</h5>
                            </div>
                            <div class="card-body">
                                @include('components.messages')
                                @if(\auth::user()->employee->is_seller)
                                    <table id="data_table" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Image</th>
                                            <th>Product Name and Code</th>
                                            <th>Listed Price</th>
                                            <th>Seller’s Price</th>
                                            <th>Available Quantity</th>
                                            <th>Sold Quantity</th>
                                            <th>Listing Status</th>
                                            <th>Listing Visibility</th>
                                            <th>Listed Date & Time</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach(\App\SellerProducts::where('agent_id', \Auth::user()->employee->id)->get() as $row)
                                            <tr>
                                                <td>{{ $loop->index+1 }}</td>
                                                <td width="80px"><img class="rounded-circle" width="80px" height="80px" src="{{ asset($row->product_info->thumbnail_image) }}" alt="product Image" /></td>
                                                <td>
                                                    {{ $row->product_info->name }}<br/>
                                                    ({{ $row->product_info->item_code }})
                                                </td>
                                                <td>{{ getCurrencyFormat($row->product_info->price) }}</td>
                                                <td>{{ getCurrencyFormat($row->product_info->seller_paid_amount) }}</td>
                                                <td><?php $count_of_stock = $row->product_info->stock; ?>
                                                    @foreach(\App\Order_items::where('product_id',$row->product_info->id)->get() as $row_check)
                                                        @if($row_check->order->status == "Pending")
                                                            <?php $count_of_stock = $count_of_stock + $row_check->qty; ?>
                                                        @endif
                                                    @endforeach
                                                    {!!  ($row->product_info->stock>0)? $count_of_stock : '<span class="text-danger">Out of Stock</span>' !!}</td>
                                                <td>{{ $row->product_info->sold }}</td>
                                                <td>{{ ($row->product_info->status == "PUBLISHED")? 'Published' : 'Unpublished'  }}</td>
                                                <td>{{ $row->product_info->visibility == 0 ? "Hidden" : 'Visible' }}</td>
                                                <td>{{ date('Y-m-d h:i:s A', strtotime($row->created_at)) }}</td>
                                                <td>
                                                    <div class="mb-2" role="group" aria-label="Basic example">
                                                        <a href="{{ route('product.details',$row->product_info->slug) }}" class="btn btn-line-fill btn-radius btn-sm"><small>View Details</small></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p><i class="fa fa-info-circle  mr-2"></i>
                                        If you have amazing products that are made with love and natural goodness
                                        with approved quality certifications and proven results for enhancing
                                        wellness, <a href="{{ route('contact-us') }}">Contact SURYA SHRI</a> to enlist them along with our gorgeous
                                        collection of products in our <a href="{{ route('products') }}">"BOUTIQUE"</a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->
    </div>
@endsection
