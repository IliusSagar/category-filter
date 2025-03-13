<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


<div class="container">
    <h2>{{ $category->name }} Products</h2>
    
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-md-3">
            <h4>Filters</h4>
            <form id="filter-form" data-slug="{{ $category->slug ?? '' }}">
                <label>Filter by Category:</label><br>
                @foreach($categories as $cat)
                    <input type="checkbox" class="category-checkbox" name="categories[]" value="{{ $cat->id }}"> {{ $cat->name }}<br>
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
            
            <!-- Pagination -->
            <div id="pagination-links">
                {{ $products->links() }}
            </div>
            
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.category-checkbox').on('change', function() {
        let selectedCategories = [];

        $('.category-checkbox:checked').each(function() {
            selectedCategories.push($(this).val());
        });

        let slug = $('#filter-form').data('slug');

        if (!slug) {
            alert("Category slug is missing!");
            return;
        }

        // ✅ Remove Old Data Immediately
        $('#product-list').empty();
        $('#pagination-links').empty();

        // ✅ If no categories selected, show "No products" and stop
        if (selectedCategories.length === 0) {
            $('#product-list').html("<p>No products found.</p>");
            return;
        }

        // ✅ Perform AJAX Request
        $.ajax({
            url: `/products/${slug}/filter`,
            type: "GET",
            data: { 'categories': selectedCategories }, 
            dataType: "json",
            beforeSend: function() {
                $('#product-list').html("<p>Loading...</p>"); // Show loading state
            },
            success: function(response) {
                let productsHtml = '';

                if (response.products.length > 0) {
                    response.products.forEach(product => {
                        productsHtml += `
                            <div class="product">
                                <h5>${product.name}</h5>
                                <p>Price: ${product.price}</p>
                            </div>`;
                    });
                } else {
                    productsHtml = "<p>No products found.</p>";
                }

                $('#product-list').html(productsHtml);
                $('#pagination-links').html(response.pagination || "");
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                alert("Something went wrong! Check the console.");
            }
        });
    });
});

</script>





