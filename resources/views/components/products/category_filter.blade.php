<div class="sidebar">
    <div class="widget">
        <button class="accordion-cus">ITEM TYPE</button>
        <div class="accordion-panel">
            <div class="cart_box cart_list_filter">
                <ul class="widget_categories widget_categories-list-style-none cart_list">
                    @if(\App\Product_category::with(['products', 'children.products'])->whereNull('parent_id')->orderby('order','ASC')->get()->count()>0)
                        <li><a href="{{ route('products') }}"><span class="categories_name {{ isset($first_lvl_category_detail)? '' : 'text-primary' }}">All Categories</span> <span class="categories_num text-danger">({{ \App\Products::where('status','PUBLISHED')->where('visibility',1)->whereNull('is_deleted')->get()->count() }})</span></a></li>
                        @foreach(\App\Product_category::with(['products','category_products', 'childrenRecursive'])->whereNull('parent_id')->orderby('order','asc')->get() as $row)
                            <li>
                                <a href="{{ route('products.category.level_one',HashEncode($row->id)) }}">
                                    <span class="{{ isset($first_lvl_category_detail)? (($row->id == $first_lvl_category_detail->id)? 'text-primary':'') : '' }}">{{ $row->name }} <span class="categories_num text-danger">
                                            (<?php $second_category_Ids = \App\Product_category::where('parent_id', $row->id)->pluck('id')->push($row->id)->all(); $third_category_Ids = $second_category_Ids = \App\Product_category::whereIn('parent_id', $second_category_Ids)->pluck('id')->push($row->id)->all(); echo \App\Products::whereIn('category_id', $third_category_Ids)->get()->count(); ?>)
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <hr/>
        @if(isset($second_categories))
            <button class="accordion-cus">CATEGORIES</button>
            <div class="accordion-panel">
                @if(count($second_categories)>0)
                    <div class="cart_box cart_list_filter">
                        <ul class="widget_categories widget_categories-list-style-none cart_list">
                            @foreach($second_categories as $child)
                                <li>
                                    <div class="custome-checkbox">
                                        <input class="form-check-input common_selector search-category" type="checkbox"
                                               name="checkbox"
                                               id="second_tg_{{ $child->id }}" value="{{ $child->id }}">
                                        <label class="form-check-label"
                                               for="second_tg_{{ $child->id }}">
                                            <span title="{{ $child->name }}">{{ \Illuminate\Support\Str::limit($child->name, 20) }}</span>

                                        </label>
                                        <span class="categories_num text-danger">(<?php $second_category_Ids = \App\Product_category::where('parent_id', $child->id)->pluck('id')->push($child->id)->all(); $third_category_Ids = $second_category_Ids = \App\Product_category::whereIn('parent_id', $second_category_Ids)->pluck('id')->push($child->id)->all(); echo \App\Products::whereIn('category_id', $third_category_Ids)->get()->count(); ?>)</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p>No Result found!</p>
                @endif
            </div>
            <hr/>
            @include('components.products.fetch_third_level_categories')
        @endif
        <button class="accordion-cus">PRICE RANGE (LKR)</button>
        <div class="accordion-panel">
            <div class="price-slider">
                <?php
                    $product_price=\App\Products::where('status','PUBLISHED')->where('visibility',1)->pluck('price')->toArray();
                ?>
                <input type="number" name="minimum_price" value="0" class="minimum_price"/> -
                <input type="number" name="maximum_price" class="maximum_price" value="{{ max($product_price) }}"/>
                <input type="hidden" id="minimum_price" value="0"/>
                <input type="hidden" id="maximum_price" value="{{ max($product_price) }}"/>
                <input value="0" min="0" max="{{ max($product_price) }}" step="1" type="range"/>
                <input value="{{ max($product_price) }}" min="0" max="{{ max($product_price) }}" step="1" type="range"/>
                <svg width="100%" height="14">
                    <line x1="4" y1="0" x2="300" y2="0" stroke="#212121" stroke-width="12"
                          stroke-dasharray="1 28"></line>
                </svg>
            </div>
        </div>
        <hr/>
        <button class="accordion-cus">AVAILABILITY</button>
        <div class="accordion-panel">
            <div class="cart_box cart_list_filter">
                <ul class="widget_categories widget_categories-list-style-none cart_list">
                    <li>
                        <div class="custome-checkbox">
                            <input type="hidden" name="available_check" id="available_check" value="no" />
                            <input class="form-check-input common_selector search-stock" type="checkbox" name="checkbox" id="stock_check" value="no">
                            <label class="form-check-label" for="stock_check"><span>Stock Availability</span></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
{{--    <div class="widget p-2 border">--}}
{{--        <div class="shop_banner ">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="icon_box text-center">--}}
{{--                        <div class="icon">--}}
{{--                            <i class="flaticon-herbal"></i>--}}
{{--                        </div>--}}
{{--                        <div class="icon_box_content p-0">--}}
{{--                            <h5>Prakrti Parīksha</h5>--}}
{{--                            <p>Find out which wellness and beauty products and services are recommended for you!--}}
{{--                                <br/><span style="font-weight: 600;">Balancing <span class="line">&#73;</span> Revitalizing</span></p>--}}
{{--                            <a href="{{ route('prakrti.products') }}" class="btn btn-md btn-primary pl-5 pr-5 pt-2 pb-2 bg-primary">Check Now &nbsp;</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
