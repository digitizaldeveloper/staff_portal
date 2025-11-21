@extends('layouts.app')
@section('page-heading', 'Staff Members')
@section('content')

<div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
    {{-- Header Section Inside Card --}}
    <div class="px-6 py-6 border-b border-gray-200 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500 mb-1">MANAGE</p>
            <h1 class="text-xl font-bold text-gray-900">Staff Members</h1>
        </div>
        <a href="{{ route('admin.staff.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded-lg shadow-sm transition">
            + 
        </a>
    </div>

    {{-- Table --}}
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Name</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Email</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Status</th>
                <th class="px-6 py-4 font-semibold text-gray-700 text-sm">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($staff as $member)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $member->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $member->email }}</td>
                    <td class="px-6 py-4 text-sm">
                        @php
                            $badgeClass = match($member->status) {
                                'Active'  => 'bg-green-100 text-green-800',
                                'Inactive'  => 'bg-red-100 text-red-800',
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">{{ $member->status }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm flex gap-2">
                        <a href="{{ route('admin.staff.edit', $member->id) }}"
                           class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white rounded text-sm transition">
                           <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                               <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                           </svg>
                        </a>
                        <button onclick="openModal({{ $member->id }})"
                                class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        {{ $staff->links() }}
    </div>                        
</div>

{{-- DELETE MODAL --}}
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg w-80 text-center shadow-lg">
        <h2 class="text-xl font-semibold mb-2 text-gray-900">Delete Staff Member?</h2>
        <p class="text-sm text-gray-600 mb-6">Are you sure you want to delete this staff member?</p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div class="flex justify-center gap-3">
                <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded text-sm transition">
                    Cancel
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm transition">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteForm').action = '/admin/staff/delete/' + id;
}

function closeModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>

@endsection
