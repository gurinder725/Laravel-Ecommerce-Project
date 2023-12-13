@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="productCreate">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Title">
                                            <p class="errors"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Slug</label>
                                            <input type="text" name="slug" id="slug" class="form-control"
                                                placeholder="Title">
                                            <p class="errors"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                placeholder="Description"></textarea>
                                            <p class="errors"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 image-thumb" id="image-thumb" style="">

                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control"
                                                placeholder="Price">
                                            <p class="errors"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price"
                                                class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at
                                                price. Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                placeholder="sku">
                                            <p class="errors"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control"
                                                placeholder="Barcode">
                                            <p class="errors"></p>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" name="track_qty" value="No">
                                                <input class="custom-control-input" type="checkbox" value="Yes"
                                                    id="track_qty" name="track_qty" checked>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>
                                                <p class="errors"></p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty"
                                                class="form-control" placeholder="Qty">
                                            <p class="errors"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">

                                        <option value="">Select Category</option>
                                        @if (!empty($categories))
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <p class="errors"></p>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select Sub Category</option>

                                    </select>
                                    <p class="errors"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="bramd" class="form-control">
                                        <option value="">Select Brand</option>
                                        @if (!empty($brands))
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="errors"></p>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                    <p class="errors"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="products.html" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('script')
    <script>
        jQuery(document).ready(function() {

            jQuery('.summernote').summernote();

            $('#title').change(function() {
                var elem = $(this);
                $("input[type=submit]").prop('disabled', true);
                $.ajax({
                    url: '{{ route('getSlug') }}',
                    type: 'get',

                    data: {
                        title: elem.val()
                    },
                    dataType: 'json',
                    success: function(response) {
                        $("input[type=submit]").prop('disabled', false);
                        //   console.log(response.status);
                        if (response.status == 'true') {
                            //  console.log('hghgh');
                            $('#slug').val(response.slug);
                        } else {
                            //$('#slug').val('');
                        }

                    },

                });
            });


            $('#category').change(function() {

                let id = $(this).val();
                $.ajax({
                    url: '{{ route('GetCategorySubCategory') }}',
                    type: 'get',

                    data: {
                        category_id: id
                    },
                    dataType: 'json',
                    success: function(response) {

                        if (response.status == true) {

                            $('#sub_category').find('option').not(':first').remove();
                            $.each(response['subcategories'], function(key, item) {
                                $('#sub_category').append(
                                    `<option value="${item.id}">${item.name}</option>`
                                );
                            });

                        }

                    },
                    error: function() {
                        console.log('something wrong');
                    }

                });
            });


            $('#productCreate').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $("button[type=submit]").prop('disabled', true);
                $.ajax({
                    url: '{{ route('products.store') }}',
                    type: 'post',

                    data: formData,
                    dataType: 'json',
                    success: function(response) {

                        if (response.status == true) {
                            window.location.href = '{{ route('products') }}';
                        }

                        if (response.status == false) {
                            $("button[type=submit]").prop('disabled', false);
                            console.log('enter');
                            var errors = response['errors'];
                            $('.errors').removeClass('invalid-feedback').html('');
                            $.each(errors, function(key, value) {

                                $(`#${key}`).addClass('is-invalid').siblings('p')
                                    .addClass('inavlid-feedback')
                                    .html(`${value}`);
                            });


                        }

                    },
                    error: function() {
                        console.log('something wrong');
                    }

                });
            });

        });

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            // init: function() {
            //     this.on('addedfile', function(file) {
            //         if (this.files.length > 1) {
            //             this.removeFile(this.files[0]);
            //         }
            //     });
            // },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                console.log(response);

                let html = `<div class="col-md-3"><input type="hidden" name="image_id[]" value="` + response
                    .image_id +
                    `"><div class="card" width="16%;"><img src="` + response
                    .image_path + `" class="card-img-top" alt="Image"> <div class="card-body">

      <button class="btn btn-danger">Delete</button>
    </div>
  </div></div>`;

                jQuery('#image-thumb').append(html);


            }
        });
    </script>
@endsection
