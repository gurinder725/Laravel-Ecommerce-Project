@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
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
            <form action="" method="post" id="categoryFormUpdate">
                <div class="card">
                    {{--                     {{ dd($category) }} --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" value="{{ $category->name }}" id="name"
                                        class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                        value="{{ $category->slug }}"class="form-control" placeholder="Slug">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="slug" class="form-control">
                                        <option value="1" @if ($category->status == 1) selected @endif>Active
                                        </option>
                                        <option value="0" @if ($category->status == 0) selected @endif>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                                <input type="hidden" name="image_id" id="image_id" value="">
                                <img src="{{ asset('uploads/category/' . $category->image . '') }}" width="100px"
                                    height="100px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <input type="submit" value="Create" class="btn btn-primary">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('script')
    <script>
        $('#categoryFormUpdate').submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $("input[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('categories.update', $category->id) }}',
                type: 'post',
                dataType: 'json',
                data: element.serializeArray(),
                success: function(response) {



                    if (response['status'] == true) {
                        window.location.href = '{{ route('categories') }}';

                        $("button[type=submit]").prop('disabled', false);


                        $('#name').removeClass('is-invalid').siblings('p').removeClass(
                            'inavlid-feedback').html('');


                        $('#slug').removeClass('is-invalid').siblings('p').removeClass(
                            'inavlid-feedback').html('');


                    } else {
                        $("button[type=submit]").prop('disabled', false);
                        var errors = response['error'];
                        if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p').addClass('inavlid-feedback')
                                .html(errors['name']);
                        }
                        if (errors['slug']) {
                            $('#slug').addClass('is-invalid').siblings('p').addClass('inavlid-feedback')
                                .html(errors['slug']);
                        }

                    }

                },
                error: function(jqXHR, exception) {
                    console.log('Something went wrong');
                }
            });
        });

        $('#name').change(function() {
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

        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                //console.log(response)
            }
        });
    </script>
@endsection
