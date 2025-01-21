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

        <div class="card">

            <h5 class="card-header">Create Divisions</h5>
            <div class="card-body">
                @session('success')
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endsession
                <form action="{{ route('admin.blogs.division.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="parent_blog">Parent Blog</label>
                        <select id="parent_blog" class="form-control" name="blog_id">
                            @foreach ($blogs as $blog)
                                <option value="{{ $blog->id }}">{{ $blog->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="blog_title">Division Title</label>
                    <input type="text" id="division_title" name="title"
                        class="form-control rounded-0 @if ($errors->has('title')) is-invalid @endif"
                        placeholder="Division Title..." value="{{ old('title') }}" />
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
                Existing Divisions
            </div>
            <div class="card-body">
                <table class="table table-light">
                    <tbody>
                        <tr>
                            <td>parent blog</td>
                            <td>title</td>
                            <td>description</td>
                            <td>actions</td>
                        </tr>
                        @foreach ($divisions as $division)
                            <tr>
                                <td>{{ $division->blog->title }}</td>
                                <td>{{ $division->title }}</td>
                                <td>{{ $division->description }}</td>
                                <td>
                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#D_{{ $division->id }}">Edit</button>
                                    <form action="{{ route('admin.blogs.division.delete') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $division->id }}">
                                        <button type="submit" class="btn btn-danger">delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @foreach ($divisions as $division)
            <!-- Modal -->
            <div class="modal fade" id="D_{{ $division->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Editing {{ $division->title }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="updateDForm_{{ $division->id }}" data-id="{{ $division->id }}" method="post">
                            @csrf <!-- Add CSRF token for security -->
                            <input type="hidden" name="id" value="{{ $division->id }}">
                            <div class="modal-body">
                                <div id="errors_{{ $division->id }}" class="alert alert-danger d-none"></div>
                                <label for="title">Title</label>
                                <input class="form-control" type="text" name="title" id="title"
                                    value="{{ $division->title }}">


                                <div class="form-group">
                                    <label for="parent_blog">Parent Blog</label>
                                    <select id="parent_blog" class="form-control" name="blog_id">
                                        @foreach ($blogs as $blog)
                                            <option value="{{ $blog->id }}"
                                                @if ($division->blog_id === $blog->id) selected @endif>{{ $blog->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="description">Desc</label>
                                    <textarea class="form-control" name="description" id="description" rows="3">{{ $division->description }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                        <div id="feedback_{{ $division->id }}" class="mt-3"></div>
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
            $('[id^=updateDForm_]').on('submit', function(event) {
                event.preventDefault();

                let form = $(this);
                let dId = form.data('id');
                let formData = form.serialize();
                let feedback = $('#feedback_' + dId);
                let errorsDiv = $('#errors_' + dId);

                $.ajax({
                    url: '{{ url('admin/blogs/division/update') }}/' +
                        dId, // Include blog ID in the URL
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
