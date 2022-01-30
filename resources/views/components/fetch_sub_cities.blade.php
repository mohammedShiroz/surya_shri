<div class="filter_cities">
    @if(isset($cities))
        @if(count($cities)>0)
            <button class="accordion-cus">CITIES</button>
            <div class="">
                <div class="cart_box cart_list_filter">
                    <ul class="widget_categories widget_categories-list-style-none cart_list">
                        @foreach($cities as $k=>$city)
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input common_city_selector search-city" type="checkbox" name="checkbox"
                                           id="{{ $city->name }}" value="{{ $city->name }}">
                                    <label class="form-check-label"
                                           for="{{ $city->name }}"><span>{{ str_limit($city->name, $limit=29, '...') }}</span></label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <hr/>
    @endif
</div>