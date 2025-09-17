@props(['headers', 'rows'])

<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-xl shadow-md border border-gray-200">
        <thead class="bg-gray-50">
            <tr class="text-center">
                @foreach ($headers as $header)
                    <th class="px-6 py-3 text-lg font-semibold border-b border-gray-200">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($rows as $row)
                <tr class="hover:bg-gray-100 transition duration-200">
                    @foreach ($row as $cell)
                        <td class="px-6 py-4 border-b border-gray-200">{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
