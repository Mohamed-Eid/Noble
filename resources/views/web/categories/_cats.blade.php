{{-- <div class="categores-head">
    <div class="container">
        <div class="cat-container">
            @foreach ($all_categories as $category)
            <a href="{{route('web.get_products_by_category',$category)}}" 
                class="btn btn-cats {{ url()->current()==route('web.get_products_by_category',$category) ? 'active' : '' }}">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>
</div> --}}
    <div class="categores-head">
        <div class="container">
            <div class="cat-container">
                @foreach ($all_categories as $category)
                <a href="{{route('web.get_products_by_category',$category)}}" 
                    class="btn btn-cats {{ url()->current()==route('web.get_products_by_category',$category) ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>  
