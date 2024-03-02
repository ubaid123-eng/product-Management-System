<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<link
    rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


<style>
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


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Products</div>
                <div class="panel-body">
                    <form id="updateproductForm" class="form-horizontal" role="form" method="POST"
                        action="{{ route('products.update', ['id' => $product->id]) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="redirects_to" value="{{ URL::previous() }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">



                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Update Product</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name"
                                    value = "<?php echo $product->name; ?>" required>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="newsBody" class="col-md-4 control-label">Update Product Description</label>

                            <div class="col-md-6">
                                <textarea class="form-control" rows="8" cols="70" id="description" name="description" required><?php echo trim($product->description); ?></textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                            <label for="price" class="col-md-4 control-label">Update Product Price:<span
                                    class="required-mark" style="color:red"> *</span></label>

                            <div class="col-md-6">
                                <input id="price" type="number" min="1" class="form-control" name="price"
                                    value="{{ $product->price }}" placeholder=" Range i.e : 5">

                                @if ($errors->has('price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group{{ $errors->has('stockquantity') ? ' has-error' : '' }}">
                            <label for="stockquantity" class="col-md-4 control-label">Update Product Quantity:<span
                                    class="required-mark" style="color:red"> *</span></label>

                            <div class="col-md-6">
                                <input id="stockquantity" type="number" min="1" class="form-control"
                                    name="stockquantity" value="{{ $product->stockquantity }}"
                                    placeholder=" Range i.e : 5">

                                @if ($errors->has('stockquantity'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stockquantity') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" onclick="updateProduct()" class="btn btn-success">
                                    <i class="fa fa-check"></i> Update
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-danger">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>

                        <br /><br />

                        <!-- Preloader Start -->
                        <div id="loader-wrapper">
                            <div id="loader"></div>
                            <div class="loader-section section-left"></div>
                            <div class="loader-section section-right"></div>
                        </div>
                        <!-- Preloader End -->


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function updateProduct() {
        var formData = new FormData(document.getElementById('updateproductForm'));
        event.preventDefault(); // Prevent the form from submitting
        $('#loader-wrapper').show(); // Show the loader

        $.ajax({
            type: 'POST',
            url: '{{ route('products.update', ['id' => $product->id]) }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-HTTP-Method-Override': 'PATCH' // Include the method override header
            },
            success: function(response) {
                // Handle the success response


                $('#name').val('');
                $('#description').val('');
                $('#price').val('');
                $('#stockquantity').val('');


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
            title: 'product Update!',
            text: 'The product has been update successfully.',
            icon: 'success',
            width: 600,
            padding: "3em",
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
            text: errorMessage,
            icon: 'error',
            width: 600,
            padding: "3em",
        });
    }
</script>
