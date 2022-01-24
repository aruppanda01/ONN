<script>
    CKEDITOR.replace('description');
    /* 
        It's usesd to validate  product varient
        Like different size, different color and different price
    */
    var i = 0;
    var k = 0;
    $('#add_varient').on('click', function(e) {

        // start
        var errorFlagOne = 0;
        var inputs = document.getElementById('add_multiple_varient').getElementsByTagName('input');
        var selectInputs = document.getElementById('add_multiple_varient').getElementsByTagName('select');

        for (var i = 0; i < inputs.length; ++i) {
            let input_value = inputs[i].value;
            if (inputs[i].type === 'text') {
                if (inputs[i].value === '') {
                    if (k == 0) {
                        setTimeout(() => {
                            $('.color_err').text('');
                        }, 5000);
                        $('.color_err').text('Colour filed can\'t be blank');
                    } else {
                        setTimeout(() => {
                            $('.color_err' + (k)).text('');
                        }, 5000);
                        $('.color_err' + (k)).text('Colour filed can\'t be blank');
                    }
                    errorFlagOne = 1;
                }
                if (inputs[i].length > 500) {
                    setTimeout(() => {
                        $('.textarea_error').text('You can add a color within 255 characters');
                    }, 5000);
                    errorFlagOne = 1;
                }
            }
            if (inputs[i].type === 'number') {
                if (inputs[i].value === '') {
                    if (k == 0) {
                        setTimeout(() => {
                            $('.price_err').text('');
                        }, 5000);
                        $('.price_err').text('Price filed can\'t be blank');
                    } else {
                        setTimeout(() => {
                            $('.price_err' + (k)).text('');
                        }, 5000);
                        $('.price_err' + (k)).text('Price filed can\'t be blank');
                    }
                    errorFlagOne = 1;
                }
            }
        }
        for (var i = 0; i < selectInputs.length; ++i) {
            let input_value = selectInputs[i].value;
            if (selectInputs[i].value === '') {
                if (k == 0) {
                    setTimeout(() => {
                        $('.size_err').text('');
                    }, 5000);
                    $('.size_err').text('Size filed can\'t be blank');
                } else {
                    setTimeout(() => {
                        $('.size_err' + (k)).text('');
                    }, 5000);
                    $('.size_err' + (k)).text('Colour filed can\'t be blank');
                }
                errorFlagOne = 1;
            }
        }
        // end

        if (errorFlagOne == 1) {
            return false;
        } else {
            $("#add_multiple_varient").append(`<hr>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">Available Sizes<span class="text-danger">*</span></label>
                        <select class="form-control" name="addMoreInputFields[${i}][sizes]">
                            <option value="">Select Size</option>
                            @foreach ($available_product_sizes as $avl_size)
                                <option value="{{ $avl_size->size }}">{{ $avl_size->size }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger size_err${i}"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">Colour<span class="text-danger">*</span></label>
                        <input type="text" id="colors" class="form-control" name="addMoreInputFields[${i}][colors]"
                            value="{{ old('colors') }}" min="1">
                        <span class="text-danger color_err${i}"></span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group edit-box">
                        <label for="review">Price<span class="text-danger">*</span></label>
                        <input type="number" id="price" class="form-control" name="addMoreInputFields[${i}][price]"
                            value="{{ old('price') }}" min="1">
                        <span class="text-danger price_err${i}"></span>
                    </div>
                </div>
            `);
            ++i;
            ++k;
        }
    });

    /*
        It's usesd to store  product varient
        Like different size, different color and different price
    */
    $('#btn_submit').on('click',function(e) {
        e.preventDefault();
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "To create this product!",
            iconHtml: '<img src="{{ asset('admin/img/logo-inverse.png') }}">',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                event.preventDefault();
               
                // start
        var errorFlagOne = 0;
        var inputs = document.getElementById('add_multiple_varient').getElementsByTagName('input');
        var selectInputs = document.getElementById('add_multiple_varient').getElementsByTagName('select');

        for (var i = 0; i < inputs.length; ++i) {
            let input_value = inputs[i].value;
            if (inputs[i].type === 'text') {
                if (inputs[i].value === '') {
                    if (k == 0) {
                        setTimeout(() => {
                            $('.color_err').text('');
                        }, 5000);
                        $('.color_err').text('Colour filed can\'t be blank');
                    } else {
                        setTimeout(() => {
                            $('.color_err' + (k)).text('');
                        }, 5000);
                        $('.color_err' + (k)).text('Colour filed can\'t be blank');
                    }
                    errorFlagOne = 1;
                }
                if (inputs[i].length > 500) {
                    setTimeout(() => {
                        $('.textarea_error').text('You can add a color within 255 characters');
                    }, 5000);
                    errorFlagOne = 1;
                }
            }
            if (inputs[i].type === 'number') {
                if (inputs[i].value === '') {
                    if (k == 0) {
                        setTimeout(() => {
                            $('.price_err').text('');
                        }, 5000);
                        $('.price_err').text('Price filed can\'t be blank');
                    } else {
                        setTimeout(() => {
                            $('.price_err' + (k)).text('');
                        }, 5000);
                        $('.price_err' + (k)).text('Price filed can\'t be blank');
                    }
                    errorFlagOne = 1;
                }
            }
        }
        for (var i = 0; i < selectInputs.length; ++i) {
            let input_value = selectInputs[i].value;
            if (selectInputs[i].value === '') {
                if (k == 0) {
                    setTimeout(() => {
                        $('.size_err').text('');
                    }, 5000);
                    $('.size_err').text('Size filed can\'t be blank');
                } else {
                    setTimeout(() => {
                        $('.size_err' + (k)).text('');
                    }, 5000);
                    $('.size_err' + (k)).text('Colour filed can\'t be blank');
                }
                errorFlagOne = 1;
            }
        }
        // end

                if (errorFlagOne == 1) {
                    return false;
                } else {
                    $('#product-form').submit();
                }
            } 
        })
    });

</script>
