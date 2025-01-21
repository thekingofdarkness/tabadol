@extends('layout.app')

@section('page.title', 'إدارة طلباتي')
@section('content')
<div class="container bg-white pt-3 pb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb rounded">
          <li class="breadcrumb-item"><a href="{{route('home')}}">الرئيسية</a></li>
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">لوحة التحكم</a></li>
          <li class="breadcrumb-item"><a>إدارة طلباتي</a></li>
        </ol>
      </nav>
    <a href="{{ route('offers.create') }}" class="btn btn-primary mb-3">وضع طلب تبادل</a>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-responsive table-bordered">
        <thead>
            <tr>
                <th class="d-none d-sm-table-cell">الاكاديمية المطلوبة</th>
                <th class="d-none d-sm-table-cell">المديرية المطلوبة</th>
                <th class="d-none d-sm-table-cell">الجماعة/المقاطعة المطلوبة</th>
                <th>المؤسسة المطلوبة</th>
                <th>وضعية الطلب</th>
                <th>العروض المقدمة</th>
                <th>المهام</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($offers as $offer)
                <tr>
                    <td  class="d-none d-sm-table-cell">{{ $offer->required_aref }}</td>
                    <td  class="d-none d-sm-table-cell">{{ $offer->required_dir }}</td>
                    <td  class="d-none d-sm-table-cell">{{ $offer->required_commune }}</td>
                    <td>{{ $offer->required_institution }}</td>
                    <td>{{ $offer->status_ar }}</td>
                    @if ($offer->status === "approved")
                    <td><a href="{{route('recieved.bids', $offer->id)}}">تصفح العروض</a></td>
                    @else
                    <td>------</td>
                    @endif
                    <td>
                        <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-info">عرض</a>
                        <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $offers->links() }}
</div>
@endsection
