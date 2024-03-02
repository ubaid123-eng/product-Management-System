<!-- Add these lines to your layout file -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link
    rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<style>
    /* Style for table borders */
    table#example1,
    table#example1 thead th,
    table#example1 tbody tr,
    table#example1 tbody td {
        border-color: #000;
        /* Dark black border color */
    }

    .action-button-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .action-button-container form {
        margin: 0;
        /* Remove default form margin */
    }

    .action-button-container a {
        width: 100px;
        text-align: center;
        border-radius: 5px;
        font-weight: bold;
        color: #fff;
        background-color: #FFA500;
    }


    #loader-wrapper {
        background: #000;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        transition: all 0.4s ease-out 0s;
        width: 100%;
        display: none;
        opacity: 0.4;
    }

    #loader {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        animation: 2s linear 0s normal none infinite running spin;
        border-color: #969696 transparent transparent;
        border-image: none;
        border-radius: 50%;
        border-style: solid;
        border-width: 3px;
        display: block;
        height: 80px;
        left: 50%;
        margin: -40px 0 0 -40px;
        position: relative;
        top: 50%;
        width: 80px;
        z-index: 1001;
    }

    #loader::before {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        animation: 3s linear 0s normal none infinite running spin;
        border-color: #9f9f9f transparent transparent;
        border-image: none;
        border-radius: 50%;
        border-style: solid;
        border-width: 3px;
        bottom: 5px;
        content: "";
        left: 5px;
        position: absolute;
        right: 5px;
        top: 5px;
    }

    #loader::after {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        animation: 1.5s linear 0s normal none infinite running spin;
        border-color: #c6c6c6 transparent transparent;
        border-image: none;
        border-radius: 50%;
        border-style: solid;
        border-width: 3px;
        bottom: 15px;
        content: "";
        left: 15px;
        position: absolute;
        right: 15px;
        top: 15px;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    #loader-wrapper .loader-section {
        background: #fff none repeat scroll 0 0;
        height: 100%;
        position: fixed;
        top: 0;
        width: 51%;
        z-index: 1000;
    }

    #loader-wrapper .loader-section.section-left {
        display: none;
        left: 0;
    }

    #loader-wrapper .loader-section.section-right {
        display: none;
        right: 0;
    }

    .loaded #loader-wrapper .loader-section.section-left {
        background: transparent none repeat scroll 0 0;
        transition: all 0.9s ease-out 0s;
    }

    .loaded #loader-wrapper .loader-section.section-right {
        background: transparent none repeat scroll 0 0;
        transition: all 0.9s ease-out 0s;
    }

    .loaded #loader {
        opacity: 0;
    }

    .loaded #loader-wrapper {
        background: transparent none repeat scroll 0 0;
        visibility: hidden;
    }
</style>






<!-- Main content -->
<section class="content">
    <div class="container">
        <!-- Add Product Button -->
        <div class="row mt-3 mb-4 ">
            <div class="col-sm-6 ">
                <!-- Empty column for spacing -->
            </div>
            <div class="col-sm-6  text-right" style="padding-bottom: 20px; padding-top: 20px;">
                <a href="{{ route('products.create') }}" class="btn btn-success btn-lg">+ Add Product</a>
            </div>
        </div>

        <!-- Table Section -->
        <div class="row mt-3">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <!-- Update your table -->
                        <table id="products" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="8%">Product Name</th>
                                    <th width="25%">Product Description</th>
                                    <th width="5%">Price</th>
                                    <th width="5%">Quantity</th>
                                    <th width="12%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table data -->
                                @foreach ($products as $key => $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->stockquantity }}</td>
                                        <td>
                                            <form style="display: inline-block;">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <a href="{{ route('products.edit', [$product->id]) }}"
                                                    class="btn btn-warning btn-margin">
                                                    Update
                                                </a>
                                            </form>
                                            <form id="deleteproduct" class="form-horizontal" role="form"
                                                method="POST"
                                                action="{{ route('products.destroy', ['id' => $product->id]) }}"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">

                                                <button type="button" onclick="confirmDelete()"
                                                    class="btn btn-danger btn-margin">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>

                                                <br /><br />

                                                <!-- Preloader Start -->
                                                <div id="loader-wrapper">
                                                    <div id="loader"></div>
                                                    <div class="loader-section section-left"></div>
                                                    <div class="loader-section section-right"></div>
                                                </div>
                                                <!-- Preloader End -->
                                            </form>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</section>
<!-- /.content -->








<script>
    $(document).ready(function() {
        $('#products').DataTable();
    });
</script>


<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure?',
            width: 600,
            padding: "3em",
            text: 'You are about to delete this product.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteProduct();
            }
        });
    }

    function deleteProduct() {
        var formData = new FormData(document.getElementById('deleteproduct'));
        event.preventDefault(); // Prevent the form from submitting
        $('#loader-wrapper').show(); // Show the loader

        $.ajax({
            type: 'POST',
            url: '{{ route('products.destroy', ['id' => $product->id]) }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'DELETE' // Include the method override header
            },
            success: function(response) {
                $('#loader-wrapper').hide(); // Hide the loader
                showSuccessMessage();
            },
            error: function(xhr, status, error) {
                // Handle the error response
                $('#loader-wrapper').hide(); // Hide the loader
                showError(xhr.responseText);
            }
        });
    }

    function showSuccessMessage() {
        Swal.fire({
            title: 'Product Update!',
            width: 600,
            padding: "3em",
            text: 'The product has been deleted successfully.',
            icon: 'success',
            didClose: () => {
                // Once the success message is shown, manually redirect
                window.location.href = "{{ route('products') }}";
            }
        });
    }

    function showError(responseText) {
        try {
            const response = JSON.parse(responseText);

            // Check if the response has an "errors" key
            if (response.errors) {
                // Extract and concatenate all error messages
                const errorMessages = Object.values(response.errors).flat();

                // Check if there are error messages
                if (errorMessages.length > 0) {
                    const errorMessage = errorMessages.join('\n');
                    showErrorMessage(errorMessage);
                    return;
                }
            }
        } catch (e) {
            showErrorMessage("An error occurred.");
        }
        showErrorMessage("An error occurred.");
    }

    function showErrorMessage(errorMessage) {
        Swal.fire({
            title: 'Error!',
            width: 600,
            padding: "3em",
            text: errorMessage,
            icon: 'error'
        });
    }
</script>
