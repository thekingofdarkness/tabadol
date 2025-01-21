@extends('layout.admin')

@section('content')
    <div class="container mt-5">
        <h1>Blogs management</h1>

        <code>
            <pre
                style="
    background: #000;
    border: 2px solid #c93373;
    padding-top: 15px;
    padding-bottom: 0;
    color: green;
    font-weight: bolder;
    font-size: 13px;">
            alphabitrium@android-a66a93ec9fd6327d TabdolSyS ~ $ <strong>Sudo List Blue Print Of The System</strong>
            alphabitrium@android-a66a93ec9fd6327d TabdolSyS ~ $ [BLOG]=> {
                        "division 1": [['categorie 1'=>'article 1 , article 2, ...'], ['categorie2'=>'article 1 , article 2, ...']];
                        "division 2": [['categorie 1'=>'article 1 , article 2, ...'], ['categorie2'=>'article 1 , article 2, ...']];
                     }
                        </pre>
        </code>
        <div class="row">
            <!-- Offers Card -->
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Articles</div>
                    <div class="card-body">
                        <h5 class="card-title">1502451</h5>
                        <p class="card-text">Total number of Articles.</p>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Editors</div>
                    <div class="card-body">
                        <h5 class="card-title">124501</h5>
                        <p class="card-text">Total number of users who made edits.</p>
                    </div>
                </div>
            </div>

            <!-- Bids Card -->
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Edits</div>
                    <div class="card-body">
                        <h5 class="card-title">154201248</h5>
                        <p class="card-text">Total number of edits.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">

            <h5 class="card-header">Create Blogs</h5>
            <div class="card-body">
                <div class="alert alert-info" role="alert">
                    main is the name of the blog that ll be shown in the blog section
                </div>
                @session('success')
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endsession
                <form action="{{ route('admin.blogs.store') }}" method="POST">
                    @csrf
                    <label for="blog_title">Blog Title</label>
                    <input type="text" id="blog_title" name="title"
                        class="form-control rounded-0 @if ($errors->has('title')) is-invalid @endif"
                        placeholder="Blog Title..." value="{{ old('title') }}" />
                    @if ($errors->has('title'))
                        <p class="text-danger">{{ $errors->first('title') }}</p>
                    @endif
                    <label for="blog_desc">Blog Description</label>
                    <textarea class="form-control rounded-0 @if ($errors->has('description')) is-invalid @endif" id="blog_desc"
                        name="description">{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <p class="text-danger">{{ $errors->first('description') }}</p>
                    @endif
                    <button type="submit" class="btn btn-primary mt-1">Add</button>
                </form>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                Existing Blogs
            </div>
            <div class="card-body">
                <table class="table table-light">
                    <tbody>
                        <tr>
                            <td>title</td>
                            <td>description</td>
                            <td>actions</td>
                        </tr>
                        @foreach ($blogs as $blog)
                            <tr>
                                <td>{{ $blog->title }}</td>
                                <td>{{ $blog->description }}</td>
                                <td>
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#Blog_{{ $blog->id }}">Edit</button>
                                    <form action="{{ route('admin.blogs.delete') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $blog->id }}">

                                        <button type="submit" class="btn btn-danger">delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @foreach ($blogs as $blog)
            <!-- Modal -->
            <div class="modal fade" id="Blog_{{ $blog->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editing {{ $blog->title }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="updateBlogForm_{{ $blog->id }}" data-id="{{ $blog->id }}" method="post">
                            @csrf <!-- Add CSRF token for security -->
                            <input type="hidden" name="id" value="{{ $blog->id }}">
                            <div class="modal-body">
                                <div id="errors_{{ $blog->id }}" class="alert alert-danger d-none"></div>
                                <label for="title">Title</label>
                                <input class="form-control" type="text" name="title" id="title"
                                    value="{{ $blog->title }}">
                                <div class="mb-3">
                                    <label for="description">Desc</label>
                                    <textarea class="form-control" name="description" id="description" rows="3">{{ $blog->description }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                        <div id="feedback_{{ $blog->id }}" class="mt-3"></div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[id^=updateBlogForm_]').on('submit', function(event) {
                event.preventDefault();

                let form = $(this);
                let blogId = form.data('id');
                let formData = form.serialize();
                let feedback = $('#feedback_' + blogId);
                let errorsDiv = $('#errors_' + blogId);

                $.ajax({
                    url: '{{ url('admin/blogs/update') }}/' + blogId, // Include blog ID in the URL
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        feedback.html(
                            '<div class="alert alert-success">Blog updated successfully!</div>'
                        );
                        errorsDiv.addClass('d-none'); // Hide error messages
                        // You can also update the blog title in the UI if needed
                        $('#exampleModalLabel').text('Editing ' + response.updatedBlog.title);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';

                            $.each(errors, function(key, value) {
                                errorMessages += '<p>' + value[0] + '</p>';
                            });

                            errorsDiv.html(errorMessages).removeClass('d-none');
                        } else {
                            feedback.html(
                                '<div class="alert alert-danger">An error occurred. Please try again.</div>'
                            );
                        }
                    }
                });
            });
        });
    </script>
@endsection
