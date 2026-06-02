<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}: prod_2 vs vprod_2</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    @include('partials.navbar')
    <div class="max-w-7xl mx-auto p-6 pt-6">
        <h1 class="text-2xl font-bold mb-6">{{ $title }}: prod_2 vs vprod_2</h1>

        {{-- Step 1: prod_2 data --}}
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-4 border-b border-gray-200 bg-blue-50">
                <h2 class="text-lg font-semibold text-blue-800">Step 1: Access {{ $table }} table from prod_2</h2>
            </div>

            <div class="p-4 border-b border-gray-200">
                <h3 class="font-medium text-gray-700">All {{ ucfirst($table) }} Records</h3>
                <p class="text-sm text-gray-500">Total: {{ $c1All->count() }}@if($hasSoftDeletes) (Active: {{ $c1ActiveCount }}, Inactive: {{ $c1Inactive->count() }})@endif</p>
            </div>
            <div class="overflow-x-auto max-h-80 overflow-y-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            @foreach($columns as $field => $label)
                            <th class="px-3 py-2 text-left">{{ $label }}</th>
                            @endforeach
                            @if($hasSoftDeletes)<th class="px-3 py-2 text-left">Status</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($c1All as $row)
                        <tr class="border-t border-gray-200 {{ $hasSoftDeletes && $row->deleted_at ? 'bg-red-50' : '' }}">
                            @foreach($columns as $field => $label)
                            <td class="px-3 py-1.5">{{ $row->$field ?? '-' }}</td>
                            @endforeach
                            @if($hasSoftDeletes)
                            <td class="px-3 py-1.5">{{ $row->deleted_at ? 'Inactive' : 'Active' }}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-{{ $hasSoftDeletes ? '3' : '1' }} gap-4">
                <div class="bg-blue-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">All Records</div>
                    <div class="text-xl font-bold">{{ $c1All->count() }}</div>
                </div>
                @if($hasSoftDeletes)
                <div class="bg-green-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">Active</div>
                    <div class="text-xl font-bold text-green-700">{{ $c1ActiveCount }}</div>
                </div>
                <div class="bg-red-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">Inactive</div>
                    <div class="text-xl font-bold text-red-700">{{ $c1Inactive->count() }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Step 2: vprod_2 data --}}
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-4 border-b border-gray-200 bg-purple-50">
                <h2 class="text-lg font-semibold text-purple-800">Step 2: Access {{ $table }} table from vprod_2</h2>
            </div>

            <div class="p-4 border-b border-gray-200">
                <h3 class="font-medium text-gray-700">All {{ ucfirst($table) }} Records</h3>
                <p class="text-sm text-gray-500">Total: {{ $c2All->count() }}@if($hasSoftDeletes) (Active: {{ $c2ActiveCount }}, Inactive: {{ $c2Inactive->count() }})@endif</p>
            </div>
            <div class="overflow-x-auto max-h-80 overflow-y-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            @foreach($columns as $field => $label)
                            <th class="px-3 py-2 text-left">{{ $label }}</th>
                            @endforeach
                            @if($hasSoftDeletes)<th class="px-3 py-2 text-left">Status</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($c2All as $row)
                        <tr class="border-t border-gray-200 {{ $hasSoftDeletes && $row->deleted_at ? 'bg-red-50' : '' }}">
                            @foreach($columns as $field => $label)
                            <td class="px-3 py-1.5">{{ $row->$field ?? '-' }}</td>
                            @endforeach
                            @if($hasSoftDeletes)
                            <td class="px-3 py-1.5">{{ $row->deleted_at ? 'Inactive' : 'Active' }}</td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-{{ $hasSoftDeletes ? '3' : '1' }} gap-4">
                <div class="bg-blue-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">All Records</div>
                    <div class="text-xl font-bold">{{ $c2All->count() }}</div>
                </div>
                @if($hasSoftDeletes)
                <div class="bg-green-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">Active</div>
                    <div class="text-xl font-bold text-green-700">{{ $c2ActiveCount }}</div>
                </div>
                <div class="bg-red-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">Inactive</div>
                    <div class="text-xl font-bold text-red-700">{{ $c2Inactive->count() }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Step 3: Unique vprod_2 records --}}
        @if($c2UniqueActive !== null)
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-4 border-b border-gray-200 bg-orange-50">
                <h2 class="text-lg font-semibold text-orange-800">Step 3: Unique Records from vprod_2 (excluding prod_2 duplicates)</h2>
                <p class="text-sm text-orange-700">vprod_2 records whose {{ $keyField }} does not exist in prod_2 — {{ $c2UniqueActive->count() }} records</p>
            </div>
            <div class="overflow-x-auto max-h-80 overflow-y-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            @foreach($columns as $field => $label)
                            <th class="px-3 py-2 text-left">{{ $label }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($c2UniqueActive as $row)
                        <tr class="border-t border-gray-200">
                            @foreach($columns as $field => $label)
                            <td class="px-3 py-1.5">{{ $row->$field ?? '-' }}</td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($columns) }}" class="px-3 py-4 text-center text-gray-400">No unique records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Step 4: Merged list --}}
        @if($merged !== null)
        <div class="bg-white rounded-lg shadow mb-8 border-l-4 border-green-600">
            <div class="p-4 border-b border-gray-200 bg-green-50">
                <h2 class="text-lg font-semibold text-green-800">Step 4: Merged {{ ucfirst($table) }} Records</h2>
                <p class="text-sm text-green-700">
                    @if($hasSoftDeletes)
                    prod_2 active: {{ $c1ActiveCount }} + vprod_2 unique: {{ $c2UniqueActive->count() }} = Total: {{ $mergedCount }}
                    @else
                    prod_2: {{ $c1All->count() }} + vprod_2 unique: {{ $c2UniqueActive->count() }} = Total: {{ $mergedCount }}
                    @endif
                </p>
            </div>
            <div class="overflow-x-auto max-h-96 overflow-y-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            @foreach($columns as $field => $label)
                            <th class="px-4 py-2 text-left">{{ $label }}</th>
                            @endforeach
                            <th class="px-4 py-2 text-left">Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($merged as $row)
                            @php
                                $c1KeyValues = $hasSoftDeletes ? $c1Active->pluck($keyField)->toArray() : $c1All->pluck($keyField)->toArray();
                                $source = in_array($row->$keyField, $c1KeyValues) ? 'prod_2' : 'vprod_2';
                            @endphp
                            <tr class="border-t border-gray-200">
                                @foreach($columns as $field => $label)
                                <td class="px-4 py-2">{{ $row->$field ?? '-' }}</td>
                                @endforeach
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium {{ $source === 'prod_2' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $source }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($columns) + 1 }}" class="px-3 py-4 text-center text-gray-400">No records merged</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</body>
</html>
