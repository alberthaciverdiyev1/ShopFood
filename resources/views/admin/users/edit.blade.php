@extends('admin.dashboard.dashboard')

@section('content')
    <div class="max-w-full mx-auto py-10">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Edit User</h2>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Basic Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Name</label>
                        <input type="text" name="contact_name" value="{{ old('contact_name', $user->contact_name ?? $user->name) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                {{-- Registration & Tax --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Registration Number (ИНН)</label>
                        <input type="text" name="reg_number" value="{{ old('reg_number', $user->reg_number) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Tax Number (VAT)</label>
                        <input type="text" name="tax_number" value="{{ old('tax_number', $user->tax_number) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                {{-- Contact --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label class="block text-sm font-medium mb-2">Contact Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $user->contact_phone) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                {{-- Address --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Street</label>
                        <input type="text" name="street" value="{{ old('street', $user->street) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">City</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Country</label>
                        <input type="text" name="country" value="{{ old('country', $user->country) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">ZIP</label>
                        <input type="text" name="zip" value="{{ old('zip', $user->zip) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>
                </div>

                {{-- Order Type & Discount --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Order Type</label>
                        <select name="order_type" class="w-full border rounded px-3 py-2">
                            <option value="eded" {{ $user->order_type=='eded'?'selected':'' }}>Eded</option>
                            <option value="yesik" {{ $user->order_type=='yesik'?'selected':'' }}>Yesik</option>
                            <option value="tara" {{ $user->order_type=='tara'?'selected':'' }}>Tara</option>
                            <option value="palet" {{ $user->order_type=='palet'?'selected':'' }}>Palet</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Discount %</label>
                        <input type="number" name="discount_percent" value="{{ old('discount_percent', $user->discount_percent) }}"
                               class="w-full border rounded px-3 py-2" min="0" max="100">
                    </div>
                </div>

                {{-- Status & Admin --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }} class="h-4 w-4">
                        <label class="text-sm font-medium">Active</label>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }} class="h-4 w-4">
                        <label class="text-sm font-medium">Admin</label>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="button" onclick="sendForgotPassword({{ $user->id }})"
                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Forgot Password</button>
                    <button type="submit" class="px-5 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function sendForgotPassword(userId) {
            if(!confirm("Send password reset link to this user?")) return;

            fetch(`/admin/users/forgot-password/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert(data.message);
                    } else {
                        alert('Error: ' + (data.message || 'Something went wrong'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Check console for details.');
                });
        }

    </script>

@endsection
