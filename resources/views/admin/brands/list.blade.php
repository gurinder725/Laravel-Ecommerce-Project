@extends('admin.layout.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Brands</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('brands.create') }}" class="btn btn-primary">New Brand</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" name="keyword" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th width="100">Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @if ($brands->isNotEmpty())
                                @foreach ($brands as $brand)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $brand->slug }}</td>
                                        <td>
                                            <form action="" method="">
                                                @if ($brand->status == 1)
                                                    <a class="change-status" data-status="{{ $brand->status }}"
                                                        data-id="{{ $brand->id }}"><svg
                                                            class="text-success-500 h-6 w-6 text-success"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg> </a>
                                                @else
                                                    <a class="change-status" data-status="{{ $brand->status }}"
                                                        data-id="{{ $brand->id }}"> <svg class="text-danger h-6 w-6"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg> </a>
                                                @endif
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ route('brands.edit', ['id' => $brand->id]) }}">
                                                <svg class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="#" data-id="{{ $brand->id }}"
                                                class="text-danger w-4 h-4 mr-1 delete-brand">
                                                <svg wire:loading.remove.delay="" wire:target=""
                                                    class="filament-link-icon w-4 h-4 mr-1"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor" aria-hidden="true">
                                                    <path ath fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                        $count++;
                                    @endphp
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">Records not Found</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $brands->links() }}
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>
@endsection

@section('script')
    <script>
        $('.change-status').on('click', function(e) {
            e.preventDefault();

            var element = $(this);
            var id = $(this).attr('data-id');
            var status = $(this).attr('data-status');

            $("input[type=submit]").prop('disabled', true);

            /*    if (status == 1) {
                   $(this).find('svg').removeClass('text-success').addClass('text-danger').find('path')
                       .attr('d', 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z');
                   $(this).attr('data-status', 0);
               } else {
                   $(this).find('svg').removeClass('text-danger').addClass('text-success').find('path')
                       .attr('d', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z');
                   $(this).attr('data-status', 1);
               } */
            $.ajax({
                url: '{{ route('updateStatusBrands') }}',
                type: 'get',

                data: {
                    id: id,
                    status: status
                },
                dataType: 'json',
                success: function(response) {
                    $("input[type=submit]").prop('disabled', false);
                    //   console.log(response.status);
                    if (response.status == true) {


                        let status = response.update_status;

                        if (status == 1) {
                            element.find('svg').removeClass('text-danger').addClass('text-success')
                                .find('path')
                                .attr('d', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z');
                            element.attr('data-status', 1);



                        } else {
                            element.find('svg').removeClass('text-success').addClass('text-danger')
                                .find('path')
                                .attr('d',
                                    'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
                                );
                            element.attr('data-status', 0);

                        }

                    }
                    if (response.status == false) {
                        let status = response.is_status;

                        if (status == 1) {
                            console.log(element.attr('data-status', 0));
                            element.find('svg').removeClass('text-danger').addClass('text-success')
                                .find('path')
                                .attr('d', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z');
                            element.attr('data-status', 1);
                        } else {
                            element.find('svg').removeClass('text-success').addClass('text-danger')
                                .find('path')
                                .attr('d',
                                    'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'
                                );
                            element.attr('data-status', 0);

                        }

                    }

                },

            });
        });


        $('.delete-brand').on('click', function(e) {

            e.preventDefault();

            if (confirm('Are you sure want to delete ?')) {

                var id = $(this).attr('data-id');
                var nurl = '{{ route('brands.delete', 'ID') }}';

                var url = nurl.replace('ID', id);


                $.ajax({
                    url: url,
                    type: 'get',

                    data: {},
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = '{{ route('brands') }}';

                    }

                });

            }

        });
    </script>
@endsection
