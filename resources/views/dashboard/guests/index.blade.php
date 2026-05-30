<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tamu Undangan: {{ $invitation->title }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('dashboard.invitations.show', $invitation) }}" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                    &larr; Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl relative shadow-sm flex items-center gap-2 mb-4">
                    <span class="text-lg">✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('import_errors') && count(session('import_errors')) > 0)
                <div class="bg-amber-50 border border-amber-200 text-amber-900 px-4 py-4 rounded-xl relative shadow-sm space-y-2 mb-4">
                    <div class="flex items-center gap-2 font-bold text-amber-800">
                        <span class="text-lg">⚠️</span>
                        <span>Beberapa baris dilewati / bermasalah:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-amber-700">
                        @foreach(session('import_errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Import Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Import Tamu Massal (CSV)</h3>
                    <form action="{{ route('dashboard.invitations.guests.import', $invitation) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row items-end gap-4">
                        @csrf
                        <div class="flex-1 w-full">
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File CSV Tamu</label>
                            <input type="file" name="file" id="file" required accept=".csv,text/csv,text/plain" class="block w-full border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        <div class="flex-shrink-0 w-full md:w-auto">
                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:from-indigo-700 hover:to-indigo-800 shadow-sm transition-all duration-200">
                                📤 Import CSV
                            </button>
                        </div>
                    </form>
                    <p class="mt-2 text-xs text-gray-500">
                        Format file harus CSV. Baris pertama (header) wajib memiliki kolom: <strong class="text-indigo-600">nama</strong> atau <strong class="text-indigo-600">name</strong>. Kolom opsional: <strong class="text-indigo-600">phone</strong> atau <strong class="text-indigo-600">whatsapp</strong> untuk no HP.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h3 class="text-lg font-medium text-gray-900">Daftar Tamu ({{ $guests->total() }})</h3>
                        <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 w-full sm:w-auto text-center">
                            + Tambah Tamu
                        </a>
                    </div>

                    @if($guests->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada tamu</h3>
                            <p class="mt-1 text-sm text-gray-500">Mulai tambahkan tamu untuk mengenerate link unik.</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard.invitations.guests.create', $invitation) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    + Tambah Tamu Baru
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="overflow-x-auto border border-gray-200 rounded-md">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tamu</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No HP / WhatsApp</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link Personal</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($guests as $guest)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $guest->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $guest->phone ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div class="flex items-center gap-2">
                                                    <input type="text" readonly value="{{ $guest->personalized_link }}" class="text-xs border-gray-300 rounded-md shadow-sm w-48 bg-gray-50" id="link-{{ $guest->id }}">
                                                    <button onclick="copyToClipboard('link-{{ $guest->id }}')" class="text-indigo-600 hover:text-indigo-900 text-xs" title="Copy Link">
                                                        Copy
                                                    </button>
                                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $guest->phone ?? '') }}?text={{ urlencode($guest->whatsapp_message) }}" target="_blank" class="text-green-600 hover:text-green-900 text-xs flex items-center gap-1" title="Kirim WhatsApp">
                                                        WA
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('dashboard.invitations.guests.edit', [$invitation, $guest]) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="{{ route('dashboard.invitations.guests.destroy', [$invitation, $guest]) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus tamu ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $guests->links() }}
                        </div>
                        
                        <script>
                            function copyToClipboard(id) {
                                var copyText = document.getElementById(id);
                                copyText.select();
                                copyText.setSelectionRange(0, 99999);
                                navigator.clipboard.writeText(copyText.value);
                                alert("Link dicopy!");
                            }
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
