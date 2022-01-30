<div class="sidebar">
    <div class="widget">
        <button class="accordion-cus">CATEGORIES</button>
        <div class="accordion-panel">
            <div class="cart_box cart_list_filter">
                <ul class="widget_categories widget_categories-list-style-none cart_list">
                    @if(\App\Service_category::whereNull('is_deleted')->where('visibility',1)->get()->count()>0)
                        <li><a href="{{ route('services') }}"><span class="categories_name {{ isset($first_lvl_category_detail)? '' : 'text-primary' }}">All Categories</span> <span class="categories_num text-danger">({{ \App\Service::where('visibility',1)->whereNull('is_deleted')->get()->count() }})</span></a></li>
                        @foreach(\App\Service_category::whereNull('is_deleted')->where('visibility',1)->orderby('order','asc')->get() as $row)
                            <li>
                                <a href="{{ route('services.category',$row->slug) }}">
                                    <span class="{{ isset($first_lvl_category_detail)? (($row->id == $first_lvl_category_detail->id)? 'text-primary':'') : '' }}">{{ $row->name }} <span class="categories_num text-danger">
                                            (<?php echo \App\Service::where('category_id', $row->id)->get()->count(); ?>)
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
        <button class="accordion-cus">PRICE RANGE (LKR)</button>
        <div class="accordion-panel">
            <div class="price-slider">
                <?php
                    $service_price=\App\Service::whereNull('is_deleted')->where('visibility',1)->pluck('price')->toArray();
                ?>
                <input type="number" name="minimum_price" value="100" class="minimum_price"/> -
                <input type="number" name="maximum_price" class="maximum_price" value="{{ max($service_price) }}"/>
                <input type="hidden" id="minimum_price" value="100"/>
                <input type="hidden" id="maximum_price" value="{{ max($service_price) }}"/>
                <input value="0" min="100" max="{{ max($service_price) }}" step="100" type="range"/>
                <input value="{{ max($service_price) }}" min="100" max="{{ max($service_price) }}" step="1" type="range"/>
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
                            <label class="form-check-label" for="stock_check"><span>Availability</span></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
