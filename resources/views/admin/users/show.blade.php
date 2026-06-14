@extends('admin.layout.app')

@section('title', 'Chi Tiết Người Dùng')
@section('header', 'Hồ Sơ Thành Viên')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:underline flex items-center text-sm font-semibold">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại danh sách
        </a>
        <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-xl shadow text-sm transition-colors">
            <i class="fas fa-edit mr-1"></i> Chỉnh Sửa
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex items-center gap-6">
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-3xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-gray-500 mt-1">{{ $user->email }}</p>
            </div>
        </div>
        
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Mã định danh (ID)</p>
                    <p class="font-semibold text-gray-800">#{{ $user->id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Vai trò hệ thống</p>
                    @if($user->role === 'admin')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold inline-block">Admin</span>
                    @else
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold inline-block">Khách hàng</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Ngày tham gia</p>
                    <p class="font-semibold text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Cập nhật lần cuối</p>
                    <p class="font-semibold text-gray-800">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection