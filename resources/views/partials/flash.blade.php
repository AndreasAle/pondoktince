@if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
         class="fixed inset-x-0 top-20 z-50 mx-auto max-w-md px-4">
        <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800 shadow-lg">
            <span>✅</span>
            <p class="flex-1">{{ session('success') }}</p>
            <button @click="show = false" class="text-green-600">✕</button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="container-x pt-4">
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Mohon periksa kembali:</p>
            <ul class="mt-1 list-disc pl-5">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    </div>
@endif
