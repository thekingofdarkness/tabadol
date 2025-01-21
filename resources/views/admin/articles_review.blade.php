@extends('layout.admin')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-light">
        <tbody>
            <tr>
                <td>title</td>
                <td>status</td>
                <td>action</td>
            </tr>
            @foreach ($articles as $article)
                <tr>
                    <td>
                        >
                        <a href="{{ route('blog.article.show', ['slug' => $article->article->slug, 'date' => $article->created_at->toDateString() . 'T' . $article->created_at->format('H:i:s')]) }}"
                            target="_blank">

                            {{ $article->article->title }}
                    </td>
                    <td>{{ $article->is_approved ? 'approved' : 'pending' }} at
                        {{ $article->updated_at ? $article->updated_at : $article->created_at }}</td>
                    <td class="d-flex gap-2">
                        @if (!$article->is_approved)
                            <form action="{{ route('admin.blogs.articles.approve') }}" method="POST" class="ajax-approve">
                                @csrf
                                <input type="hidden" name="id" value="{{ $article->id }}">
                                <button type="submit" class="btn btn-sm btn-success">Aprove</button>
                            </form>
                        @else
                            <form action="{{ route('admin.blogs.articles.disapprove') }}" method="POST"
                                class="ajax-approve">
                                @csrf
                                <input type="hidden" name="id" value="{{ $article->id }}">
                                <button type="submit" class="btn btn-sm btn-success">Disapprove</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.blogs.articles.delete') }}" method="POST" class="ajax-delete">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $article->id }}">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // AJAX approve
            document.querySelectorAll('.ajax-approve').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(form);
                    let actionUrl = form.getAttribute('action');

                    fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                alert(data.message);
                                location.reload(); // reload the page to reflect changes
                            } else {
                                throw data.errors;
                            }
                        })
                        .catch(errors => {
                            alert(Object.values(errors)[0][0]);
                        });
                });
            });

            // AJAX delete
            document.querySelectorAll('.ajax-delete').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    let formData = new FormData(form);
                    let actionUrl = form.getAttribute('action');

                    fetch(actionUrl, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                alert(data.message);
                                location.reload(); // reload the page to reflect changes
                            } else {
                                throw data.errors;
                            }
                        })
                        .catch(errors => {
                            alert(Object.values(errors)[0][0]);
                        });
                });
            });
        });
    </script>
@endsection
