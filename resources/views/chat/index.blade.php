@extends('layout.app')

@section('page.title', 'غرفة محادثة رقم ' . $chatRoomId)')
@section('content')
    <div class="container bg-white pb-2 pt-2">
        <h1>غرفة محادثة رقم {{ $chatRoomId }}</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <table class="table table-bordered table-striped table-light mb-2">
            <thead class="thead-light text-center">
                <tr>
                    <th colspan="2">تفاصيل العرض:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>غرفة نقاش الأعضاء</th>
                    <td>{{ $offer->user->name }} و {{$chatRoom->bid->bidder->name}}</td>
                </tr>
                <tr>
                    <th>من مؤسسة</th>
                    <td>{{ $offer->current_institution }}</td>
                </tr>
                <tr>
                    <th>نحو</th>
                    <td>{{ $offer->required_institution }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <!-- Close Room buttons -->
                        @if ($chatRoom->status == 'open')
                            @if ($offer->user->id === Auth::id())
                                <form action="{{ route('offers.updateStatusToDone', $offer->id) }}" method="post">
                                    @csrf
                                    <button class="btn btn-success btn-sm">قبول الصفقة</button>
                                </form>
                            @endif
                            @if ($offer->user->id === Auth::id() || $chatRoom->bid->bidder_id === Auth::id())
                                <form action="{{ route('chat.close', $chatRoomId) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">حظر الغرفة</button>
                                </form>
                            @endif
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="chat-box" class="chat-box">
            <p>بداية المناقشة</p>
            @foreach ($messages as $message)
                <div class="message {{ $message->sender_id == Auth::id() ? 'sent' : 'received' }}">
                    <p>{{ $message->content }}</p>
                    <small>
                        {{ $message->created_at }}
                        @if ($message->seen_at)
                            <i class="fas fa-check-circle text-success"></i> تمت قراءته
                        @endif
                    </small>
                </div>
            @endforeach
        </div>
        @if ($chatRoom->status == 'open')
            <form id="message-form">
                @csrf
                <input type="hidden" name="chat_room_id" value="{{ $chatRoomId }}">
                <div class="form-group">
                    <textarea name="content" class="form-control" rows="3" placeholder="أكتب رسالتك هنا ..."></textarea>
                </div>
                <button type="submit" class="btn btn-secondary mt-2">إرسال <i class="fa fa-paper-plane-o"></i></button>
            </form>
    </div>
@else
    <div class="alert alert-danger" role="alert">
        <strong>هذه الغرفة تم إقفال بتاريخ {{ $chatRoom->updated_at }}</strong>
    </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch messages every 5 seconds
            setInterval(fetchMessages, 10000);

            // Handle form submission with AJAX
            $('#message-form').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('chat.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        fetchMessages(); // Refresh messages after sending
                        $('textarea[name="content"]').val(''); // Clear the textarea
                    },
                    error: function(response) {
                        console.error('Error:', response);
                    }
                });
            });

            function fetchMessages() {
                fetch('{{ route('chat.getMessages', $chatRoomId) }}')
                    .then(response => response.json())
                    .then(messages => {
                        var chatBox = document.getElementById('chat-box');
                        chatBox.innerHTML = '';

                        messages.reverse().forEach(function(message) {
                            var messageClass = message.sender_id == {{ Auth::id() }} ? 'sent' :
                                'received';
                            var formattedDate = new Date(message.created_at).toLocaleString();
                            chatBox.innerHTML += `
                        <div class="message ${messageClass}">
                            <p>${message.content}</p>
                            <small>
                                ${formattedDate}
                                ${message.seen_at ? '<i class="fas fa-check-circle text-success"></i> تم قراءته' : ''}
                            </small>
                        </div>
                    `;
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    </script>
@endsection
