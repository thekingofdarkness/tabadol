@extends('layout.app')
@section('content')
    <main>
        <div class="container pt-2 pb-5 bg-md-blue">
            <div class="card card-success">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-2 mb-1 rounded">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">لوحة التحكم</a></li>
                        <li class="breadcrumb-item"><a>إعدادات الحساب</a></li>
                    </ol>
                </nav>
                <div class="card-body">
                    <div class="row gutters-sm">
                        <div class="col-sm-8">
                            <div class="card-header border-bottom mb-3 d-flex d-md-none">
                                <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                                    <li class="nav-item">
                                        <a href="#profile" data-bs-toggle="tab" class="nav-link has-icon active"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#security" data-bs-toggle="tab" class="nav-link has-icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-shield">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                            </svg></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body tab-content">
                                <div class="tab-pane active" id="profile">
                                    <h6>إعدادات الحساب</h6>
                                    <hr>
                                    <div id="feedback">
                                        <!-- Validation Errors -->
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @if (session('success'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                    </div>
                                    <form action="{{ route('update.user') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="fullName">الإسم الكامل</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ Auth::user()->name }}" aria-describedby="fullNameHelp">
                                            <small id="fullNameHelp" class="form-text text-muted">من فضلك، إستخدم إسمك
                                                الحقيقي على
                                                المنصة لتجنب حظر حسابك</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="fullName">البريد الالكتروني</label>
                                            <input type="text" name="email" class="form-control"
                                                value="{{ Auth::user()->email }}" aria-describedby="fullNameHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="fullName">رقم الهاتف</label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ Auth::user()->phone }}" aria-describedby="fullNameHelp">
                                        </div>
                                        <div class="form-group small text-muted">
                                            المعلومات الواردة اعلاه لن يتم الاطلاع عليها ولا تشاركها مع أي جهة كانت و يظل
                                            استخدام
                                            هذه البيانات متوافقا و سياسة الخصوصية المتبعة على المنصة <span
                                                class="text-underline">نحترم بشكل صارم خصوصية المستخدمين</span>.
                                        </div>
                                        <button type="submit" class="btn btn-primary">تحديث</button>
                                    </form>
                                </div>
                                <div class="tab-pane" id="security">
                                    <h6>إعدادات الامان</h6>
                                    <hr>
                                    <!-- Validation Errors -->
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if (session('successPass'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('successPass') }}
                                        </div>
                                    @endif
                                    @if (session('errorPass'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('errorPass') }}
                                        </div>
                                    @endif
                                    <form action="{{ route('update.password.user') }}" method="post">
                                        @csrf
                                        <div id="passwordRepeatValidation"></div>
                                        <div class="form-group">
                                            <label class="d-block">تغيير كلمة السر</label>
                                            <input type="text" id="oldPassword" name="current_password"
                                                class="form-control" placeholder="كلمة السر القديمة">
                                            <input type="text" id="newPassword" name="new_password"
                                                class="form-control mt-1" placeholder="كلمة السر الجديدة">
                                            <input type="text" id="newPasswordr" name="new_password_confirmation"
                                                class="form-control mt-1" placeholder="كرر كلمة السر الجديدة">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-block btn-primary mt-2">تغيير</button>
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <nav class="nav flex-column nav-pills nav-gap-y-1">
                                <a href="#profile" data-bs-toggle="tab"
                                    class="nav-item nav-link has-icon nav-link-faded active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>بيانات الحساب
                                </a>
                                <a href="#security" data-bs-toggle="tab"
                                    class="nav-item nav-link has-icon nav-link-faded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-shield mr-2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    </svg>الأمان
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection
@section('extraJs')
    <script>
        $(document).ready(function() {
            // Parse the URL to get the fragment (the part after #)
            var fragment = window.location.hash;

            // Define the tabs and their corresponding content elements
            var tabs = {
                '#security': '#profile',
                '#profile': '#security'
            };

            // Activate the tab based on the fragment
            if (fragment && tabs[fragment]) {
                activateTab(fragment, tabs[fragment]);
            }
        });

        function activateTab(activeTab, inactiveTab) {
            // Activate the active tab
            $(activeTab).addClass('active');
            $('a[href="' + activeTab + '"]').addClass('active');

            // Deactivate the inactive tab
            $(inactiveTab).removeClass('active');
            $('a[href="' + inactiveTab + '"]').removeClass('active');
        }
    </script>
@endsection
<!--
<main role="main" class="container card-body bg-md-blue" dir="rtl">
    <ul class="breadcrumb">
        <li><a href="http://tabadol.test/dashboard">Dashboard</a></li>
        <li><a>Settings</a></li>
    </ul>
    <div class="row gutters-sm">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border-bottom mb-3 d-flex d-md-none">
                    <ul class="nav nav-tabs card-header-tabs nav-gap-x-1" role="tablist">
                        <li class="nav-item">
                            <a href="#profile" data-toggle="tab" class="nav-link has-icon active"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg></a>
                        </li>
                        <li class="nav-item">
                            <a href="#security" data-toggle="tab" class="nav-link has-icon"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-shield">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg></a>
                        </li>
                    </ul>
                </div>
                <div class="card-body tab-content">
                    <div class="tab-pane active" id="profile">
                        <h6>إعدادات الحساب</h6>
                        <hr>
                        <div id="error">
                        </div>
                        <form action="http://tabadol.test/update-user" method="post">
                            <input type="hidden" name="_token" value="0PmVFApIgFfgI6mtxhj1unRJD1QkM096VOPIafes"
                                autocomplete="off">
                            <div class="form-group">
                                <label for="fullName">الإسم الكامل</label>
                                <input type="text" name="full_name" class="form-control" value="testing123"
                                    aria-describedby="fullNameHelp">
                                <small id="fullNameHelp" class="form-text text-muted">من فضلك، إستخدم إسمك الحقيقي على
                                    المنصة لتجنب حظر حسابك</small>
                            </div>
                            <div class="form-group">
                                <label for="fullName">الادارة</label>
                                <div class="form-group text-left">
                                    <select class="form-control" id="administration" name="administration_id">
                                        <option value="1" selected="">الاكاديمية الجهوية للتربية والتكوين الرباط
                                            سلا القنيطرة</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fullName">مقر العمل</label>
                                <select class="form-control" id="workplace" name="city_id">
                                    <option value="1" selected="">الرباط</option>
                                    <option value="2">القنيطرة</option>
                                    <option value="3">الحاجب</option>
                                    <option value="4">tounfite</option>
                                    <option value="6">إيتزر</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="fullName">البريد الالكتروني</label>
                                <input type="text" name="email" class="form-control" value="test@test.te"
                                    aria-describedby="fullNameHelp">
                            </div>

                            <div class="form-group small text-muted">
                                المعلومات الواردة اعلاه لن يتم الاطلاع عليها ولا تشاركها مع أي جهة كانت و يظل استخدام
                                هذه البيانات متوافقا و سياسة الخصوصية المتبعة على المنصة <span
                                    class="text-underline">نحترم بشكل صارم خصوصية المستخدمين</span>.
                            </div>
                            <button type="submit" class="btn btn-primary">تحديث</button>
                        </form>
                    </div>
                    <div class="tab-pane" id="security">
                        <h6>Security settings</h6>
                        <hr>
                        <div id="errorSecurity"></div>
                        <form action="http://tabadol.test/user-change-password" method="post">
                            <input type="hidden" name="_token" value="0PmVFApIgFfgI6mtxhj1unRJD1QkM096VOPIafes"
                                autocomplete="off">
                            <div id="passwordRepeatValidation"></div>
                            <div class="form-group">
                                <label class="d-block">Change password</label>
                                <input type="text" id="oldPassword" name="current_password" class="form-control"
                                    placeholder="you previous password">
                                <input type="text" id="newPassword" name="new_password" class="form-control mt-1"
                                    placeholder="your new password">
                                <input type="text" id="newPasswordr" name="new_password_confirmation"
                                    class="form-control mt-1" placeholder="repeat it">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">change password</button>
                            </div>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-none d-md-block">
            <div class="card">
                <div class="card-body">
                    <nav class="nav flex-column nav-pills nav-gap-y-1">
                        <a href="#profile" data-toggle="tab"
                            class="nav-item nav-link has-icon nav-link-faded active">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mr-2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>بيانات الحساب
                        </a>
                        <a href="#security" data-toggle="tab" class="nav-item nav-link has-icon nav-link-faded">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-shield mr-2">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            </svg>الأمان
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>
-->
