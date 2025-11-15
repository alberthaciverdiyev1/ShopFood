@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-6xl mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Users</h2>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Registered At</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $user->email }}</td>
                            <td class="px-6 py-3">{{ $user->name }}</td>
                            <td class="px-6 py-3">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-3">
                                @if($user->is_active)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Active</span>
                                @elseif(!$user->is_active && !$user->is_send_email)
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded">Inactive</span>
                                @elseif(!$user->is_active && $user->is_send_email)
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-center space-x-2">
                                {{-- Confirm / Toggle --}}
                                <form action="{{ route('admin.users.confirm', ['id'=>$user->id]) }}" method="POST"
                                      class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="px-3 py-1 rounded text-white bg-green-600 hover:bg-green-700">
                                        Confirm User
                                    </button>
                                </form>

                                {{-- Edit --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</a>

                                {{-- Delete --}}
                                <button onclick="openDeleteModal({{ $user->id }})"
                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete
                                </button>

                                {{-- Details --}}
                                <a href="{{ route('admin.users.show', $user->id) }}"
                                   class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">Details</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div id="deleteUserModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-sm rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-bold mb-4 text-red-600">Delete User</h3>
            <p class="mb-6">Are you sure you want to delete this user?</p>
            <form id="deleteUserForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeDeleteModal()"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Delete
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(userId) {
            const modal = document.getElementById('deleteUserModal');
            modal.classList.remove('hidden');
            document.getElementById('deleteUserForm').action = `/admin/users/${userId}`;
        }

        function closeDeleteModal() {
            document.getElementById('deleteUserModal').classList.add('hidden');
        }
    </script>
@endsection
