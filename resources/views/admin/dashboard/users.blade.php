@extends('admin.dashboard.dashboard')

@section('content')
<div class="p-6">

    <!-- Header -->
    <h1 class="text-2xl font-bold mb-4">Dashboard</h1>

    <!-- Top banner -->
    <div class="bg-gradient-to-r from-yellow-500 to-amber-700 text-white p-4 rounded-lg mb-6 flex justify-between items-center">
        <span class="font-medium">⭐ Star this project on GitHub</span>
        <a href="/https://github.com/alberthaciverdiyev1/ShopFood" class="underline">View more →</a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="dashboard-card">
            <div class="icon icon-clients"><i class="fas fa-users"></i></div>
            <div>
                <p class="text-sm text-gray-500">Total clients</p>
                <p class="text-xl font-bold">{{ $users->count() }}</p>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="icon icon-balance"><i class="fas fa-wallet"></i></div>
            <div>
                <p class="text-sm text-gray-500">Account balance</p>
                <p class="text-xl font-bold">$46,760.89</p>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="icon icon-sales"><i class="fas fa-shopping-cart"></i></div>
            <div>
                <p class="text-sm text-gray-500">New sales</p>
                <p class="text-xl font-bold">376</p>
            </div>
        </div>

        <div class="dashboard-card">
            <div class="icon icon-contacts"><i class="fas fa-comments"></i></div>
            <div>
                <p class="text-sm text-gray-500">Pending contacts</p>
                <p class="text-xl font-bold">35</p>
            </div>
        </div>
    </div>

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
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-medium">{{ $user->email }}</p>
                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                        </div>
                    </div>
                </td>
                <td>{{ $user->contact_name }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($user->is_verified)
                        <span class="status-approved">Verified</span>
                    @else
                        <span class="status-pending">Pending</span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-2">
                        @if(!$user->email_verified_at)
                            <form  action="{{ route('admin.users.toggle', ['user'=>$user]) }}" method="POST"  style="display: inline;">
                                @csrf
                                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                                    Confirm
                                </button>
                            </form>
                        @endif

                        <a href="" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                            Edit
                        </a>

                            <a href="{{route('user.details',['id'=>$user->id])}}" class="bg-orange-500 hover:bg-orange-500 text-white px-3 py-1 rounded text-sm">
                                Show
                            </a>

                        <form action="{{route('users.delete',['id'=>$user->id])}}" method="POST" style="display: inline;" onsubmit="return confirm('Bu istifadəçini silmək istədiyinizdən əminsiniz?')">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
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
