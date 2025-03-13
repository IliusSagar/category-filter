<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


<div class="container">
    <h2>Products</h2>
    
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-3">
            <h4>Filters</h4>
            <form id="filter-form">
                <label>Category:</label><br>
                @foreach($categories as $category)
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"> {{ $category->name }}<br>
                @endforeach
            </form>
        </div>

        <!-- Products Section -->
        <div class="col-md-9">
            <div id="product-list">
                @foreach($products as $product)
                    <div class="product">
                        <h5>{{ $product->name }}</h5>
                        <p>Price: {{ $product->price }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('input[name="categories[]"]').on('change', function() {
            let selectedCategories = [];
            $('input[name="categories[]"]:checked').each(function() {
                selectedCategories.push($(this).val());
            });

            $.ajax({
                url: "{{ route('products.filter') }}",
                type: "GET",
                data: { categories: selectedCategories },
                success: function(response) {
                    let productsHtml = '';
                    response.products.forEach(product => {
                        productsHtml += `<div class="product">
                            <h5>${product.name}</h5>
                            <p>Price: ${product.price}</p>
                        </div>`;
                    });

                    $('#product-list').html(productsHtml);
                }
            });
        });
    });
</script>



