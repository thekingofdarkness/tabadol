@extends('layouts.admin')

@section('content')
    <table class="table table-light">
        <tbody>
            <tr>
                <td>title</td>
                <td>action</td>
            </tr>
            <tr>
                <td>title</td>
                <td><a href="{{route('admin.blogs.articles.approve')" class="btn btn-primary">Set As Approved</a></td>
                <td><a href="{{route('admin.blogs.articles.delete')" class="btn btn-primary">Delete</a></td>
            </tr>
        </tbody>
    </table>
@endsection
