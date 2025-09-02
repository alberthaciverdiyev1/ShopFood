
<table border="1">
    <tr>
        <th>Email</th>
        <th>Action</th>
    </tr>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->is_active == 1)
                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background:red; color:white;">Deactivate</button>
                    </form>
                @elseif($user->is_active == 0 && $user->is_send_email == 0)
                    <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="background:green; color:white;">Activate</button>
                    </form>
                @elseif($user->is_active == 0 && $user->is_send_email == 1)
                    <button style="background:orange; color:white;" disabled>Pending</button>
                @endif
            </td>
        </tr>
    @endforeach
</table>
