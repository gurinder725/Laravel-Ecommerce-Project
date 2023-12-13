@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="brands.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="brandsform">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="slug" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Create</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('script')
    <script>
        $('#brandsform').submit(function(e) {
            e.preventDefault();
            var element = $(this);
            $("input[type=submit]").prop('disabled', true);
            $.ajax({
                url: '{{ route('brands.store') }}',
                type: 'post',
                dataType: 'json',
                data: element.serializeArray(),
                success: function(response) {



                    if (response['status'] == true) {
                        window.location.href = '{{ route('brands') }}';

                        $("button[type=submit]").prop('disabled', false);


                        $('#name').removeClass('is-invalid').siblings('p').removeClass(
                            'inavlid-feedback').html('');


                        $('#slug').removeClass('is-invalid').siblings('p').removeClass(
                            'inavlid-feedback').html('');


                    } else {
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
