@extends('admin.dashboard.dashboard')

@section('content')
    <div class="p-6">

        <!-- User Table -->
        <h2 class="text-xl font-semibold mb-4">User List</h2>
        <table class="table-style">
            <thead class="bg-gray-100">
            <tr>
                <th>Email</th>
                <th>Ad</th>
                <th>Qeydiyyat tarixi</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                 class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-medium">{{ $user->email }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->contact_name }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($user->is_active)
                            <span class="status-approved">Verified</span>
                        @elseif($user->is_send_email)
                            <span class="status-sent">Mail sent</span>
                        @else
                            <span class="status-pending">Waiting</span>

                        @endif
                    </td>
                    <td>
                        <div class="flex gap-2">
                            @if(!$user->email_verified_at)
                                <form action="{{ route('admin.users.confirm', ['id'=>$user->id]) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    <button type="submit"
                                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                        @if($user->is_send_email)
                                            Resend
                                        @else
                                            Confirm
                                        @endif
                                    </button>
                                </form>
                            @endif

                            <a href="{{route('admin.users.edit',['id'=>$user->id])}}"
                               class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>

                            <a href="{{route('user.details',['id'=>$user->id])}}"
                               class="bg-orange-500 hover:bg-orange-500 text-white px-3 py-1 rounded text-sm">
                                Details
                            </a>

                            <form action="{{route('users.delete',['id'=>$user->id])}}" method="POST"
                                  style="display: inline;"
                                  onsubmit="return confirm('Bu istifadəçini silmək istədiyinizdən əminsiniz?')">
                                @csrf
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if($users->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">Heç bir istifadəçi tapılmadı.</p>
            </div>
        @endif
    </div>

    <style>
        .status-approved {
            background-color: #10b981;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-sent {
            background-color: #3B82F6;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background-color: #f59e0b;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-denied {
            background-color: #ef4444;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
    </style>
@endsection
