@extends('layout.admin')
@section('content')
    <h1>Chat Rooms</h1>
    <table class="table table-stripped" border="1">
        <thead>
            <tr>
                <th>Chat Room ID</th>
                <th>bidder</th>
                <th>receiver</th>
                <th>last activity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chatRooms as $chatRoom)
                @php
                    $created_at = $chatRoom->created_at;
                    $updated_at = $chatRoom->updated_at;
                    $latest_message_created_at = $chatRoom->messages->isNotEmpty()
                        ? $chatRoom->messages->max('created_at')
                        : null;
                    $latest_message_seen_at = $chatRoom->messages->isNotEmpty()
                        ? $chatRoom->messages->max('seen_at')
                        : null;

                    $dates = array_filter([
                        $created_at,
                        $updated_at,
                        $latest_message_created_at,
                        $latest_message_seen_at,
                    ]);
                    $latest_date = !empty($dates) ? max($dates) : null;
                @endphp
                <tr>
                    <td>{{ $chatRoom->id }} </td>
                    <td>{{ $chatRoom->bid->bidder->name }}</td>
                    <td>{{ $chatRoom->bid->receiver->name }}</td>
                    <td>
                        @php
                            $date = $latest_date;

                            // Check if $latest_date is a string and create a DateTime object
                            if (is_string($date)) {
                                try {
                                    $date = new \DateTime($date);
                                } catch (\Exception $e) {
                                    $date = null; // If the string is not a valid date
                                }
                            }
                            echo $date ? $date->format('Y-m-d H:i:s') : 'No date available';
                        @endphp
                    </td>
                    <td>{{ $chatRoom->status }}</td>
                    <td>
                        <a href="{{ route('admin.showChatRoom', $chatRoom->id) }}">View Messages</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
