<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Distribusi Responden per Indikator
        </x-slot>
        <x-slot name="description">
            Jumlah responden berdasarkan skala penilaian untuk setiap unsur pelayanan.
        </x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-left divide-y table-auto fi-ta-table divide-gray-200 dark:divide-white/5">
                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr>
                        <th class="px-3 py-3 text-sm font-semibold text-gray-900 sm:px-6 dark:text-white">Unsur Pelayanan</th>
                        <th class="px-3 py-3 text-sm font-semibold text-center text-gray-900 sm:px-6 dark:text-white">Buruk (1)</th>
                        <th class="px-3 py-3 text-sm font-semibold text-center text-gray-900 sm:px-6 dark:text-white">Cukup (2)</th>
                        <th class="px-3 py-3 text-sm font-semibold text-center text-gray-900 sm:px-6 dark:text-white">Baik (3)</th>
                        <th class="px-3 py-3 text-sm font-semibold text-center text-gray-900 sm:px-6 dark:text-white">Sangat Baik (4)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                    @foreach ($distributions as $key => $counts)
                        <tr class="bg-white dark:bg-gray-900">
                            <td class="px-3 py-4 text-sm text-gray-900 sm:px-6 dark:text-white">
                                {{ $indicatorNames[$key] }}
                            </td>
                            <td class="px-3 py-4 text-sm text-center sm:px-6">
                                @if($counts['1'] > 0)
                                    <x-filament::badge color="danger">{{ $counts['1'] }}</x-filament::badge>
                                @else
                                    <span class="text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm text-center sm:px-6">
                                @if($counts['2'] > 0)
                                    <x-filament::badge color="warning">{{ $counts['2'] }}</x-filament::badge>
                                @else
                                    <span class="text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm text-center sm:px-6">
                                @if($counts['3'] > 0)
                                    <x-filament::badge color="success">{{ $counts['3'] }}</x-filament::badge>
                                @else
                                    <span class="text-gray-500">0</span>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm text-center sm:px-6">
                                @if($counts['4'] > 0)
                                    <x-filament::badge color="success">{{ $counts['4'] }}</x-filament::badge>
                                @else
                                    <span class="text-gray-500">0</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
