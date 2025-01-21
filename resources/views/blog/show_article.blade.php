@extends('layout.app')
@section('page.title', $oarticle->title)
@section('og:title', $oarticle->title)
@section('meta_description', "قراءة مقالة في موضوع : $oarticle->title ")
@section('og:description', "قراءة مقالة في موضوع : $oarticle->title ")
@section('og:image', url(Storage::url($oarticle->thumbnail)))


@section('content')
    <div class="container pt-2 pb-5 bg-white">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1 rounded">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">المدونة</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('blog.index', ['division' => $oarticle->category->division->id]) }}">{{ $oarticle->category->division->title }}</a>
                </li>
                <li class="breadcrumb-item"><a>{{ $oarticle->category->title }}</a></li>
            </ol>
        </nav>
        @if (Auth::user() and Auth::user()->is_admin)
            <form action="{{ route('admin.blogs.articles.delete_2') }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $oarticle->id }}">
                <button type="submit" class="btn btn-danger">حذف المقالة</button>
            </form>
        @endif
        <div class="article-header text-center">
            <h1>{{ $oarticle->title }}</h1>
            @if (!$pendingArticleContent and !$original)
                <p><small>اخر تعديل :
                        @if (!empty($article->versions) && $article->versions->contains('is_approved', true))
                            {{ $article->updated_at }}
                        @else
                            {{ $article->created_at }}
                        @endif
                        من طرف {{ $article->user->name }}
                    </small>
                </p>
            @elseif ($original)
                <p><small>نسخة أصلية بتاريخ {{ $article->created_at->format('Y-m-d H:i:s') }} من طرف
                        {{ $article->user->name }}</small></p>
            @else
                <p><small>نسخة غير مستقرة بتاريخ {{ $pendingArticleContent->created_at->format('Y-m-d H:i:s') }} من طرف
                        {{ $pendingArticleContent->user->name }}</small></p>
            @endif
            <img src="{{ Storage::url($oarticle->thumbnail) }}" alt="صورة : {{ $oarticle->title }}"
                class="img-fluid img-thumbnail mt-2 mb-2" style="max-width:300px;">
            @if ($pendingArticleContent)
                <div class="alert alert-warning" role="alert">
                    هذه النسخة غير مستقرة أو قديمة، للاطلاع على النسخة المستقرة للمقالة <a
                        href="{{ route('blog.article.show', ['slug' => $oarticle->slug]) }}" class="btn btn-warning">إضغط
                        هنا</a>
                </div>
            @elseif($original)
                <div class="alert alert-warning" role="alert">
                    أنت تطالع النسخة الأصلية للمقالة قد يكون وقع عليها تعديل وتحسين لمطالعة النسخة المستقرة الحالية<a
                        href="{{ route('blog.article.show', ['slug' => $oarticle->slug]) }}" class="btn btn-warning">إضغط
                        هنا</a>
                </div>
            @endif
        </div>

        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs article-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="read-tab" data-bs-toggle="tab" data-bs-target="#read" type="button"
                    role="tab" aria-controls="read" aria-selected="true">إقرأ</button>
            </li>
            @auth
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button"
                        role="tab" aria-controls="edit" aria-selected="false">عدل</button>
                </li>
            @endauth
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button"
                    role="tab" aria-controls="history" aria-selected="false">سجل التعديلات</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            <!-- Read Tab -->
            <div class="tab-pane fade show active" id="read" role="tabpanel" aria-labelledby="read-tab">
                @if (!$pendingArticleContent || $original)
                    {!! $article->content !!}
                @else
                    {!! $pendingArticleContent->content !!}
                @endif
            </div>

            @auth
                <!-- Edit Tab -->
                <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                    @if (!empty($article_version))
                        <div class="alert alert-info mt-2" role="alert">
                            <p><strong>ملاحظة:</strong> لديك مقترح تعديل للمقالة لا يزال تحت طور المراجعة، لذلك يمكنك بناء
                                تعديلاتك على اخر نسخة تعديل قدمتها بتاريخ: {{ $article_version->created_at }}</p>
                            <hr />
                        </div>
                    @endif
                    <div class="btn-toolbar editor-toolbar" role="toolbar" aria-label="Editor Toolbar">
                        <div class="btn-group me-2 mt-1" role="group">
                            <button type="button" class="btn btn-outline-secondary" onclick="execCmd('bold')"
                                title="Bold"><b>G</b></button>
                            <button type="button" class="btn btn-outline-secondary" onclick="execCmd('italic')"
                                title="Italic"><i>I</i></button>
                            <button type="button" class="btn btn-outline-secondary" onclick="execCmd('underline')"
                                title="Underline"><u>S</u></button>
                        </div>
                        <div class="btn-group me-2 mt-1" role="group">
                            <button type="button" class="btn btn-outline-secondary" onclick="execCmd('justifyRight')"
                                title="Align Right"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-text-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M6 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m4-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-4-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                                </svg></button>
                            <button type="button" class="btn btn-outline-secondary" onclick="execCmd('justifyCenter')"
                                title="Align Center"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-text-center" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M4 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                                </svg></button>
                            <button type="button" class="btn btn-outline-secondary" onclick="execCmd('justifyLeft')"
                                title="Align Left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-text-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2 12.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                                </svg></button>
                        </div>
                        <div class="btn-group me-2 mt-1" role="group">
                            <button type="button" class="btn btn-outline-secondary" onclick="execCmd('insertUnorderedList')"
                                title="Unordered List"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5zM3 3H2v1h1z" />
                                    <path
                                        d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1z" />
                                    <path fill-rule="evenodd"
                                        d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5zM2 7h1v1H2zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm1 .5H2v1h1z" />
                                </svg></button>
                            <button type="button" class="btn btn-outline-secondary" onclick="execCmd('insertOrderedList')"
                                title="Ordered List"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-list-ol" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5" />
                                    <path
                                        d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635z" />
                                </svg></button>
                        </div>
                        <div class="btn-group me-2 mt-1" role="group">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="execCmd('createLink', prompt('Enter URL:', 'http://'))"
                                title="Insert Link">رابط</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                                    id="fontSizeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    حجم الخط
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="fontSizeDropdown">
                                    <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '10')">10</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '11')">11</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '12')">12</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '13')">13</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '14')">14</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '15')">15</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '16')">16</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group me-2 mt-1" role="group">
                            <button type="button" class="btn btn-outline-secondary" onclick="createTable()"
                                title="Insert Table">جدول</button>
                        </div>
                        <div class="btn-group me-2 mt-1" role="group">
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#imageUploadModal" title="Insert Image">صورة</button>
                        </div>
                    </div>

                    <div id="feedBackDiv" class="mt-2"></div>
                    <div id="editor" class="editor" contenteditable="true">
                        @if (!empty($article_version))
                            {!! $article_version->content !!}
                        @else
                            {!! $article->content !!}
                        @endif
                    </div>
                    <button id="saveButton" class="btn btn-primary mt-3">نشر</button>
                </div>
            @endauth
            <!-- History Tab -->
            <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                <ul>
                    @foreach ($versions as $version)
                        <li>
                            <a
                                href="{{ route('blog.article.show', ['slug' => $version->article->slug, 'date' => $version->created_at->toDateString() . 'T' . $version->created_at->format('H:i:s')]) }}">
                                تم اقتراح نسخة {{ $version->created_at->format('Y-m-d H:i:s') }} من طرف
                                {{ $version->user->name }}
                            </a>
                        </li>
                    @endforeach
                    <li>
                        <a
                            href="{{ route('blog.article.show', ['slug' => $oarticle->slug, 'date' => $oarticle->created_at->toDateString() . 'T' . $oarticle->created_at->format('H:i:s'), 'original' => 'true']) }}">
                            النسخة الأصلية بتاريخ {{ $oarticle->created_at->format('Y-m-d H:i:s') }} من طرف
                            {{ $oarticle->user->name }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Comments Section -->
        <hr class="w-100">
        <div class="comments-section mt-5">
            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <form action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="article_id" value="{{ $oarticle->id }}">
                @if (!Auth::check())
                    <div class="mb-3">
                        <label for="name" class="form-label">الاسم</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="content" class="form-label">التعليق</label>
                    <textarea class="form-control" id="content" name="content" rows="3" required>{{ old('content') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="captcha" class="form-label">رمز التحقق</label>
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <img src="{{ Captcha::src() }}" alt="CAPTCHA" id="captcha-img" class="captcha-img"
                                onclick="refreshCaptcha()">
                        </div>
                        <input type="text" class="form-control rounded-0 @error('captcha') is-invalid @enderror"
                            id="captcha" name="captcha" required>
                    </div>

                    @error('captcha')
                        <div class="text-danger">خطأ في رمز التحقق</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success rounded-0">إرسال</button>
            </form>
            <div class="w-100 mt-2 actual-comments">

                @foreach ($oarticle->comments->sortByDesc('created_at') as $comment)
                    <div class="mt-3">

                        <div class="comment-body p-3 shadow-sm">
                            <div class="mb-3">
                                <h5 class="text-dark mb-0">{{ $comment->name }}</h5>
                                <span class="text-muted fs-6">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>

                            <p>
                                {{ $comment->content }}
                            </p>
                            @if (Auth::check() and Auth::user()->is_admin || Auth::user()->id === $comment->uid)
                                <ul class="list-inline d-sm-flex my-0">
                                    <li class="list-inline-item ml-auto">
                                        <a class="btn btn-sm btn-danger"
                                            href="{{ route('comments.delete', $comment->id) }}">
                                            حذف التعليق
                                        </a>
                                    </li>
                            @endif
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('extraJs')
    <script>
        // JavaScript functions for handling image uploads and editor actions
        function refreshCaptcha() {
            document.getElementById('captcha-img').src = '{{ Captcha::src() }}' + '?' + Math.random();
        }
        async function uploadImage() {
            const fileInput = document.getElementById('imageInput');
            const loader = document.getElementById('loader');
            const uploadError = document.getElementById('uploadError');

            if (fileInput.files.length === 0) {
                alert('من فضلك قم باختيار صورة');
                return;
            }

            const file = fileInput.files[0];
            const formData = new FormData();
            formData.append('image', file);

            loader.style.display = 'inline-block';

            try {
                const response = await fetch('{{ route('auth.upload.image') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                });

                if (!response.ok) {
                    throw new Error('واجهنا خطأ غير متوقع في الشبكة حاول مجددا لاحقا');
                }

                const data = await response.json();
                const imageUrl = data.url; 

                insertImage(imageUrl);
                document.getElementById('imageUploadForm').reset();
                loader.style.display = 'none';
                uploadError.classList.add('d-none');
                bootstrap.Modal.getInstance(document.getElementById('imageUploadModal')).hide();
            } catch (error) {
                loader.style.display = 'none';
                uploadError.classList.remove('d-none');
            }
        }

        function insertImage(url) {
            const editor = document.getElementById('editor');
            const img = document.createElement('img');
            img.src = url;
            img.className = 'img-fluid';
            img.style.width = "300px";
            editor.appendChild(img);
        }

        function execCmd(command, value = null) {
            document.execCommand(command, false, value);
            if (command === 'justifyCenter') {
                applyClassToSelectedElement('text-center');
            } else if (command === 'justifyLeft') {
                applyClassToSelectedElement('text-start');
            } else if (command === 'justifyRight') {
                applyClassToSelectedElement('text-end');
            }
        }

        function applyClassToSelectedElement(className) {
            const selection = window.getSelection();
            if (!selection.rangeCount) return;
            const range = selection.getRangeAt(0).cloneRange();
            const span = document.createElement('span');
            span.className = className;
            range.surroundContents(span);
            selection.removeAllRanges();
            selection.addRange(range);
        }

        function createTable() {
            const rows = prompt('Enter number of rows', '2');
            const cols = prompt('Enter number of columns', '2');
            if (rows > 0 && cols > 0) {
                let table = '<table class="table table-bordered"><tbody>';
                for (let r = 0; r < rows; r++) {
                    table += '<tr>';
                    for (let c = 0; c < cols; c++) {
                        table += '<td>&nbsp;</td>';
                    }
                    table += '</tr>';
                }
                table += '</tbody></table>';
                execCmd('insertHTML', table);
            }
        }

        document.getElementById('saveButton').addEventListener('click', async function() {
            var saveButton = document.getElementById('saveButton');
    saveButton.disabled = true;
    saveButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> نشر...';
            const editorContent = document.getElementById('editor').innerHTML;
            const feedBackDiv = document.getElementById('feedBackDiv');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const formData = new FormData();
            formData.append('content', editorContent);
            formData.append('article_id', '{{ $oarticle->id }}');

            try {
                const response = await fetch('{{ route('blog.article.update') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                if (response.ok) {
                    const responseData = await response.json();
                    feedBackDiv.innerHTML = `
                        <div class="alert alert-success">
                          ${responseData.Message}
                        </div>
                    `;
                saveButton.disabled = false;
            saveButton.innerHTML = 'نشر';
                    document.getElementById('feedBackDiv').scrollIntoView({ behavior: 'smooth' });
                } else if (response.status === 422) {
                    const errorData = await response.json();
                    let errorMessages = '';
                    for (const [key, value] of Object.entries(errorData.errors)) {
                        errorMessages += `<p>${value}</p>`;
                    }
                    feedBackDiv.innerHTML = `
                        <div class="alert alert-danger">
                          ${errorMessages}
                        </div>
                    `;
                    
                saveButton.disabled = false;
            saveButton.innerHTML = 'نشر';
                    document.getElementById('feedBackDiv').scrollIntoView({ behavior: 'smooth' });
                } else {
                    throw new Error('وقع خطأ ما في حفظ المقالة');
                    
                saveButton.disabled = false;
            saveButton.innerHTML = 'نشر';
                }
            } catch (error) {
                feedBackDiv.innerHTML = `
                    <div class="alert alert-danger">
                        Error: ${error.message}
                    </div>
                `;
                
                saveButton.disabled = false;
            saveButton.innerHTML = 'نشر';
                    document.getElementById('feedBackDiv').scrollIntoView({ behavior: 'smooth' });
            }
        });
    </script>
@endsection
