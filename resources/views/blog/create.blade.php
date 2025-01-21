@extends('layout.app')
@section('content')
    <main>
        <div class="container pt-2 pb-5 bg-white">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-2 mb-1 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a>تحرير مقالة</a></li>
                </ol>
            </nav>

            <div id="feedBack"></div>
            <h1>تحرير مقالة </h1>
            <!--
            <div class="alert alert-info" role="alert">
                نصائح لكتابة مقالة ذات جودة :
                <ul>
                    <li>تجنب النسخ واللصق من المواقع الاخرى</li>
                    <li>بخصوص المقالات حول المدن والقرى تطرق على الاقل إلى : العرض التعليمي، العرض الصحي، النقل، متوسط اسعار
                        الكراء و نفقات العيش...</li>
                    <li>قم بمراجعة المقالة التي قمت بتحريرها لتجنب الاخطاء الاملائية</li>
                </ul>
            </div>
            -->
            <label for="title">عنوان المقالة :</label>
            <input type="text" name="title" id="title" class="form-control rounded-0 mb-2"
                placeholder="عنوان المقالة">
            <label for="thumbnail">صورة المقالة</label>
            <input type="file" name="thumb" id="thumbnail" class="mb-2">

            <div class="form-group">
                <label for="division">الأقسام</label>
                <select id="division" class="form-control" name="division_id">
                    <option selected>من فضلك قم بإختيار قسم (الزامي)</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}">{{ $division->title }}</option>
                    @endforeach
                </select>
            </div>

            <div id="category-container" class="form-group mt-3 d-none">
                <label for="category">التصنيفات</label>
                <select id="category" class="form-control" name="category_id">
                    <!-- Categories will be appended here -->
                </select>
            </div>

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
                        onclick="execCmd('createLink', prompt('Enter URL:', 'http://'))" title="Insert Link">رابط</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" id="fontSizeDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            حجم الخط
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="fontSizeDropdown">
                            <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '10')">10</a></li>
                            <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '11')">11</a></li>
                            <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '12')">12</a></li>
                            <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '13')">13</a></li>
                            <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '14')">14</a></li>
                            <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '15')">15</a></li>
                            <li><a class="dropdown-item" href="#" onclick="execCmd('fontSize', '16')">16</a></li>
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
            <div id="editor" class="editor" contenteditable="true"></div>

            <button id="saveButton" class="btn btn-primary mt-3">نشر</button>
        </div>
        <!-- Image Upload Modal -->
        <div class="modal fade" id="imageUploadModal" tabindex="-1" aria-labelledby="imageUploadModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageUploadModalLabel">أدرج صورة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="imageUploadForm">
                            <div class="mb-3">
                                <label for="imageInput" class="form-label">إختر صورة</label>
                                <input class="form-control" type="file" id="imageInput" accept="image/*">
                            </div>
                            <div class="loader" id="loader"></div>
                            <div class="alert alert-danger d-none" id="uploadError">واجهنا خطأ في رفع الصورة تأكد من أن
                                الحجم
                                أقل 2 ميغابايت</div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="button" class="btn btn-primary" onclick="uploadImage()">رفع</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('extraJs')
    <script>
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
                const imageUrl = data.url; // Assume the endpoint returns the image URL in a "url" field

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
            const rows = prompt('ما هو عدد اسطر الجدول', '2');
            const cols = prompt('ما هو عدد اعمدة الجدول', '2');
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
            const title = document.getElementById('title').value;
            const thumbnailInput = document.getElementById('thumbnail');
            const category_id = document.getElementById('category').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (thumbnailInput.files.length === 0) {
                alert('من فضلك قم باختيار صورة للمقالة.');
                saveButton.disabled = false;
            saveButton.innerHTML = 'نشر';
                return;
            }

            const thumbnail = thumbnailInput.files[0];

            // Check file size (2MB = 2 * 1024 * 1024 bytes)
            if (thumbnail.size > 2 * 1024 * 1024) {
                alert('حجم الصورة يجب أن يكون أقل من 2 ميغابايت.');
                saveButton.disabled = false;
            saveButton.innerHTML = 'نشر';
                return;
            }

            const formData = new FormData();
            formData.append('content', editorContent);
            formData.append('title', title);
            formData.append('category_id', category_id);
            formData.append('thumbnail', thumbnail);

            try {
                const response = await fetch('{{ route('blog.article.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                });

                const responseData = await response.json();

                if (response.ok) {
                    window.location.href = responseData.articleUrl; // Redirect to the new article
                } else {
                    displayErrors(responseData.errors); // Display validation errors
                    saveButton.disabled = false;
            saveButton.innerHTML = 'نشر';
                }
            } catch (error) {
                alert('Error: ' + error.message);
                saveButton.disabled = false;
            saveButton.innerHTML = 'نشر';
            }
        });

        function displayErrors(errors) {
            // Get the feedback element
            const feedbackElement = document.getElementById('feedBack');

            // Check if the feedback element exists
            if (!feedbackElement) {
                console.error('Element with ID "feedBack" not found.');
                return;
            }

            // Clear previous errors
            feedbackElement.innerHTML = '';

            // Display new errors
            for (const [field, messages] of Object.entries(errors)) {
                const errorHtml = `<div class="alert alert-danger" role="alert">${messages.join('<br>')}</div>`;
                feedbackElement.insertAdjacentHTML('beforeend', errorHtml);
            }

            // Scroll to feedback section
            feedbackElement.scrollIntoView({
                behavior: 'smooth'
            });
        }

        $(document).ready(function() {
            $('#division').on('change', function() {
                var divisionId = $(this).val();
                if (divisionId) {
                    $.ajax({
                        url: '/get-categories/' + divisionId,
                        type: 'GET',
                        success: function(response) {
                            var categorySelect = $('#category');
                            categorySelect.empty(); // Clear existing options
                            categorySelect.append('<option value="">إختر تصنيفا</option>');
                            $.each(response.categories, function(key, value) {
                                categorySelect.append('<option value="' + value.id +
                                    '">' + value.title + '</option>');
                            });
                            $('#category-container').removeClass(
                                'd-none'); // Show the category dropdown
                        },
                        error: function(xhr) {
                            console.error('Error fetching categories:', xhr);
                        }
                    });
                } else {
                    $('#category-container').addClass(
                        'd-none'); // Hide the category dropdown if no division is selected
                }
            });
        });
    </script>
@endsection
