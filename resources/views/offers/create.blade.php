@extends('layout.app')

@section('page.title', 'إضافة طلب')
@section('content')
    <div class="container pt-2 pb-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb rounded">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                <li class="breadcrumb-item"><a href="{{ route('offers.index') }}">إدارة طلباتي</a></li>
                <li class="breadcrumb-item"><a>إضافة طلب</a></li>
            </ol>
        </nav>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('offers.store') }}" method="POST">
            @csrf

            <!-- Group 1: Current Position -->
            <div class="card mb-3">
                <div class="card-header">المنصب الحالي (من)</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="current_cadre" class="form-label">حدد الهيئة التي تنتمي إليها</label>
                        <select class="form-select" id="current_cadre" name="current_cadre" required>
                            <option value="" disabled selected>حدد الهيئة التي تنتمي إليها</option>
                            @foreach ($frameworks as $framework)
                                <option value="{{ $framework->codename }}"
                                    {{ old('current_cadre') == $framework->codename ? 'selected' : '' }}>أستاذ
                                    {{ $framework->arabic_name }}
                                </option>
                            @endforeach

                        </select>

                        @error('current_cadre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="current_aref" class="form-label">حدد الاكاديمية الحالية التي تشتغل بها</label>
                        <select class="form-select @error('current_aref') is-invalid @enderror" id="current_aref"
                            name="current_aref" required>
                            <option value="" disabled selected>حدد الاكاديمية الحالية التي تشتغل بها</option>
                            <option value="AREF-CS" {{ old('current_aref') == 'AREF-CS' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة الدار البيضاء-سطات</option>
                            <option value="AREF-RSK" {{ old('current_aref') == 'AREF-RSK' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة الرباط-سلا-القنيطرة</option>
                            <option value="AREF-TTH" {{ old('current_aref') == 'AREF-TTH' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة طنجة-تطوان-الحسيمة</option>
                            <option value="AREF-FM" {{ old('current_aref') == 'AREF-FM' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة فاس-مكناس</option>
                            <option value="AREF-MS" {{ old('current_aref') == 'AREF-MS' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة مراكش-آسفي</option>
                            <option value="AREF-SM" {{ old('current_aref') == 'AREF-SM' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة سوس-ماسة</option>
                            <option value="AREF-BMK" {{ old('current_aref') == 'AREF-BMK' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة بني ملال-خنيفرة</option>
                            <option value="AREF-DT" {{ old('current_aref') == 'AREF-DT' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة درعة-تافيلالت</option>
                            <option value="AREF-O" {{ old('current_aref') == 'AREF-O' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة الشرق</option>
                            <option value="AREF-GN" {{ old('current_aref') == 'AREF-GN' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة كلميم-واد نون</option>
                            <option value="AREF-LS" {{ old('current_aref') == 'AREF-LS' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة العيون-الساقية الحمراء</option>
                            <option value="AREF-DWD" {{ old('current_aref') == 'AREF-DWD' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة الداخلة-وادي الذهب</option>
                        </select>
                        @error('current_aref')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="speciality" class="form-label">التخصص</label>
                        <input type="text" class="form-control @error('speciality') is-invalid @enderror" id="speciality"
                            name="speciality" value="{{ old('speciality') }}" placeholder="ضع مربي او مزدوج او المادة المدرسة ...">
                        @error('speciality')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="current_dir" class="form-label">المديرية الحالية</label>
                        <input type="text" class="form-control @error('current_dir') is-invalid @enderror"
                            id="current_dir" name="current_dir" value="{{ old('current_dir') }}" required>
                        @error('current_dir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="current_commune" class="form-label">الجماعة الحالية</label>
                        <input type="text" class="form-control @error('current_commune') is-invalid @enderror"
                            id="current_commune" name="current_commune" value="{{ old('current_commune') }}" required>
                        @error('current_dir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="current_institution" class="form-label">المؤسسة الحالية</label>
                        <input type="text"
                            class="form-control @error('current_commune') is-invalid @enderror id="current_institution"
                            name="current_institution" value="{{ old('current_institution') }}" required>
                        @error('current_dir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Group 2: Desired Position -->
            <div class="card mb-3">
                <div class="card-header">المنصب المطلوب (إلى)</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="required_aref" class="form-label">الاكاديمية المطلوبة</label>
                        <select class="form-select @error('required_aref') is-invalid @enderror" id="required_aref"
                            name="required_aref" required>
                            <option value="" disabled selected>حدد الاكاديمية الحالية التي تشتغل بها</option>
                            <option value="AREF-CS" {{ old('current_aref') == 'AREF-CS' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة الدار البيضاء-سطات</option>
                            <option value="AREF-RSK" {{ old('current_aref') == 'AREF-RSK' ? 'selected' : '' }}>
                                الأكاديمية
                                الجهوية للتربية والتكوين لجهة الرباط-سلا-القنيطرة</option>
                            <option value="AREF-TTH" {{ old('current_aref') == 'AREF-TTH' ? 'selected' : '' }}>
                                الأكاديمية
                                الجهوية للتربية والتكوين لجهة طنجة-تطوان-الحسيمة</option>
                            <option value="AREF-FM" {{ old('current_aref') == 'AREF-FM' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة فاس-مكناس</option>
                            <option value="AREF-MS" {{ old('current_aref') == 'AREF-MS' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة مراكش-آسفي</option>
                            <option value="AREF-SM" {{ old('current_aref') == 'AREF-SM' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة سوس-ماسة</option>
                            <option value="AREF-BMK" {{ old('current_aref') == 'AREF-BMK' ? 'selected' : '' }}>
                                الأكاديمية
                                الجهوية للتربية والتكوين لجهة بني ملال-خنيفرة</option>
                            <option value="AREF-DT" {{ old('current_aref') == 'AREF-DT' ? 'selected' : '' }}>
                                الأكاديمية
                                الجهوية للتربية والتكوين لجهة درعة-تافيلالت</option>
                            <option value="AREF-O" {{ old('current_aref') == 'AREF-O' ? 'selected' : '' }}>الأكاديمية
                                الجهوية للتربية والتكوين لجهة الشرق</option>
                            <option value="AREF-GN" {{ old('current_aref') == 'AREF-GN' ? 'selected' : '' }}>
                                الأكاديمية
                                الجهوية للتربية والتكوين لجهة كلميم-واد نون</option>
                            <option value="AREF-LS" {{ old('current_aref') == 'AREF-LS' ? 'selected' : '' }}>
                                الأكاديمية
                                الجهوية للتربية والتكوين لجهة العيون-الساقية الحمراء</option>
                            <option value="AREF-DWD" {{ old('current_aref') == 'AREF-DWD' ? 'selected' : '' }}>
                                الأكاديمية
                                الجهوية للتربية والتكوين لجهة الداخلة-وادي الذهب</option>
                        </select>
                        @error('required_aref')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="required_dir" class="form-label">المديرية المطلوبة</label>
                        <input type="text" class="form-control @error('required_dir') is-invalid @enderror"
                            id="required_dir" name="required_dir" value="{{ old('required_dir') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="required_commune" class="form-label">الجماعة المطلوبة</label>
                        <input type="text" class="form-control @error('required_commune') is-invalid @enderror"
                            id="required_commune" name="required_commune" value="{{ old('required_commune') }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="required_institution" class="form-label">المؤسسة المطلوبة</label>
                        <input type="text" class="form-control" id="required_institution" name="required_institution"
                            value="{{ old('required_institution') }}" required>
                        @error('required_institution')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">ملاحظات (اختياري)</label>
                        <textarea class="form-control" id="note" name="note">{{ old('note') }}</textarea>

                        @error('note')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">إرسال</button>
        </form>
    </div>
@endsection
