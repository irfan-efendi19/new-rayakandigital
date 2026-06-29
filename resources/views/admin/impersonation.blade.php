<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-heading text-2xl font-bold text-secondary-800 dark:text-neutral-100">Intip Dasbor Pengguna</h2>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-0.5">Pilih pengguna untuk melihat dasbor dari perspektif mereka.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-secondary-800 rounded-xl sm:rounded-2xl shadow-sm border border-neutral-100 dark:border-secondary-700 overflow-hidden">
                <div class="px-4 sm:px-6 py-4 border-b border-neutral-100 dark:border-secondary-700">
                    <h3 class="font-heading text-base sm:text-lg font-bold text-secondary-800 dark:text-neutral-100">Daftar Pengguna</h3>
                </div>

                <div class="p-4 sm:p-6">
                    @if($users->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-neutral-500 dark:text-neutral-400">Tidak ada pengguna ditemukan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-neutral-100 dark:border-secondary-700">
                                        <th class="text-left py-3 px-4 font-semibold text-secondary-800 dark:text-neutral-100">Nama</th>
                                        <th class="text-left py-3 px-4 font-semibold text-secondary-800 dark:text-neutral-100">Email</th>
                                        <th class="text-center py-3 px-4 font-semibold text-secondary-800 dark:text-neutral-100">Undangan</th>
                                        <th class="text-right py-3 px-4 font-semibold text-secondary-800 dark:text-neutral-100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr class="border-b border-neutral-50 dark:border-secondary-700/50 hover:bg-neutral-50 dark:hover:bg-secondary-700/30 transition-colors">
                                            <td class="py-3 px-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900 flex items-center justify-center text-primary-700 dark:text-primary-300 font-semibold text-sm">
                                                        {{ substr($user->name, 0, 1) }}
                                                    </div>
                                                    <span class="font-medium text-secondary-800 dark:text-neutral-200">{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-neutral-600 dark:text-neutral-400">{{ $user->email }}</td>
                                            <td class="py-3 px-4 text-center">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300">
                                                    {{ $user->invitations_count }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-right">
                                                <form action="{{ route('admin.impersonate.switch', $user) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary-600 text-white rounded-lg text-xs font-semibold hover:bg-primary-700 transition-colors"
                                                        onclick="return confirm('Intip dasbor {{ $user->name }}? Anda akan melihat dasbor sebagai pengguna ini.')">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        Intip
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
