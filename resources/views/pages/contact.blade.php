@extends('layout.app')

@section('content')
    <div class="privacy">
        <section class="hero text-center py-5">
            <div class="container">
                <h1>تواصل معنا</h1>
                <p class="lead">الاتصال بنا لأي استفسار، فلا تترددوا في استخدام معلومات الاتصال اسفله.</p>
            </div>
        </section>
    </div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="list-group">
                    <a href="https://wa.me/0709499366" target="_blank" class="list-group-item list-group-item-action d-flex align-items-center">
                        <img src="https://img.icons8.com/ios-filled/50/000000/whatsapp.png" alt="WhatsApp Icon" class="me-3" style="width: 24px; height: 24px;">
                        <span>0709499366</span>
                    </a>
                    <a href="mailto:abderrahman4bouichou@gmail.com" class="list-group-item list-group-item-action d-flex align-items-center">
                        <img src="https://img.icons8.com/ios-filled/50/000000/email.png" alt="Email Icon" class="me-3" style="width: 24px; height: 24px;">
                        <span>abderrahman4bouichou@gmail.com</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
