@extends('layout.admin')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mb-4">Offers</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>UID</th>
                        <th>Current Cadre</th>
                        <th>Current AREF</th>
                        <th>Current DIR</th>
                        <th>Current Commune</th>
                        <th>Current Institution</th>
                        <th>Required AREF</th>
                        <th>Required DIR</th>
                        <th>Required Commune</th>
                        <th>Required Institution</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Speciality</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offers as $offer)
                        <tr>
                            <td>{{ $offer->id }}</td>
                            <td>{{ $offer->uid }}</td>
                            <td>{{ $offer->current_cadre }}</td>
                            <td>{{ $offer->current_aref }}</td>
                            <td>{{ $offer->current_dir }}</td>
                            <td>{{ $offer->current_commune }}</td>
                            <td>{{ $offer->current_institution }}</td>
                            <td>{{ $offer->required_aref }}</td>
                            <td>{{ $offer->required_dir }}</td>
                            <td>{{ $offer->required_commune }}</td>
                            <td>{{ $offer->required_institution }}</td>
                            <td>{{ $offer->note }}</td>
                            <td>{{ $offer->status }}</td>
                            <td>{{ $offer->speciality }}</td>
                            <td>{{ $offer->created_at }}</td>
                            <td>{{ $offer->updated_at }}</td>
                            <td>
                                @if($offer->status != 'approved')
                                    <form action="{{ route('admin.offers.approve', $offer->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                @else
                                    <span class="badge bg-secondary">Approved</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
