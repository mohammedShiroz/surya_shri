<div class="fetch_third_level_categories_data">
    @if(isset($third_categories))
        @if(count($third_categories)>0)
            <button class="accordion-cus">SUB CATEGORIES</button>
            <div class="">
                <div class="cart_box cart_list_filter">
                    <ul class="widget_categories widget_categories-list-style-none cart_list">
                        @foreach($third_categories as $child)
                            <li>
                                <div class="custome-checkbox">
                                    <input class="form-check-input common_category_selector search-sub-category" type="checkbox"
                                           name="checkbox"
                                           id="third_tg_{{ $child->id }}" value="{{ $child->id }}">
                                    <label class="form-check-label"
                                           for="third_tg_{{ $child->id }}"><span title="{{ $child->name }}">{{ \Illuminate\Support\Str::limit($child->name, 20) }}
                                           </span>
                                    </label>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr/>
        @endif
    @endif
</div>

