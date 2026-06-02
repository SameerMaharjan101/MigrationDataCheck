<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Comparison: prod_2 vs vprod_2</title>
    @vite('resources/css/app.css')
    {{-- Alpine.js removed --}}
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    @include('partials.navbar')
    <div class="max-w-7xl mx-auto p-6 pt-6">
        <h1 class="text-2xl font-bold mb-6">User Comparison: prod_2 vs vprod_2</h1>

        @if(isset($filterConfig) && count($filterConfig) > 0)
        <div class="bg-white rounded-lg shadow mb-6 p-4">
            <form method="GET" action="{{ url()->current() }}" class="flex flex-wrap items-end gap-6">
                @foreach($filterConfig as $col => $cfg)
                <div class="flex gap-4 items-end">
                    <div>
                        <label for="c1-filter-{{ $col }}" class="block text-xs font-medium text-gray-600 mb-1">{{ $cfg['label'] }} <span class="text-blue-600">(prod_2)</span></label>
                        <select name="c1_{{ $col }}" id="c1-filter-{{ $col }}" class="filter-select border border-gray-300 rounded px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">All</option>
                            @foreach($c1FilterValues[$col] ?? [] as $option)
                            <option value="{{ $option['value'] }}" {{ (isset($c1ActiveFilters[$col]) && $c1ActiveFilters[$col] == $option['value']) ? 'selected' : '' }}>{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="c2-filter-{{ $col }}" class="block text-xs font-medium text-gray-600 mb-1">{{ $cfg['label'] }} <span class="text-purple-600">(vprod_2)</span></label>
                        <select name="c2_{{ $col }}" id="c2-filter-{{ $col }}" class="filter-select border border-gray-300 rounded px-3 py-1.5 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">All</option>
                            @foreach($c2FilterValues[$col] ?? [] as $option)
                            <option value="{{ $option['value'] }}" {{ (isset($c2ActiveFilters[$col]) && $c2ActiveFilters[$col] == $option['value']) ? 'selected' : '' }}>{{ $option['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endforeach
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-1.5 rounded text-sm hover:bg-blue-700">Filter</button>
                    @if((isset($c1ActiveFilters) && count($c1ActiveFilters) > 0) || (isset($c2ActiveFilters) && count($c2ActiveFilters) > 0))
                    <a href="{{ url()->current() }}" class="bg-gray-200 text-gray-700 px-4 py-1.5 rounded text-sm hover:bg-gray-300 inline-block">Clear</a>
                    @endif
                </div>
            </form>
        </div>
        <script>
            document.querySelectorAll('.filter-select').forEach(function(el) {
                el.addEventListener('change', function() { this.form.submit(); });
            });
        </script>
        @endif

        {{-- Step 1: Access user table from prod_2 --}}
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-4 border-b border-gray-200 bg-blue-50">
                <h2 class="text-lg font-semibold text-blue-800">Step 1: Access user table from prod_2</h2>
            </div>

            <div class="p-4 border-b border-gray-200">
                <h3 class="font-medium text-gray-700">All Users</h3>
                <p class="text-sm text-gray-500">Total: {{ $prod2AllUsers->total() }} (Active: {{ $prod2ActiveUsers->count() }}, Inactive: {{ $prod2InactiveUsers->count() }})</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left w-10">SN</th>
                            <th class="px-3 py-2 text-left">ID</th>
                            <th class="px-3 py-2 text-left">Username</th>
                            <th class="px-3 py-2 text-left">First Name</th>
                            <th class="px-3 py-2 text-left">Last Name</th>
                            <th class="px-3 py-2 text-left">Email</th>
                            <th class="px-3 py-2 text-left">Deleted At</th>
                            <th class="px-3 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prod2AllUsers as $user)
                        <tr class="border-t border-gray-200 {{ $user->deleted_at ? 'bg-red-50' : '' }}">
                            <td class="px-3 py-1.5 text-gray-400">{{ ($prod2AllUsers->currentPage() - 1) * $prod2AllUsers->perPage() + $loop->iteration }}</td>
                            <td class="px-3 py-1.5">{{ $user->id }}</td>
                            <td class="px-3 py-1.5 font-medium">{{ $user->username }}</td>
                            <td class="px-3 py-1.5">{{ $user->first_name }}</td>
                            <td class="px-3 py-1.5">{{ $user->last_name }}</td>
                            <td class="px-3 py-1.5">{{ $user->email }}</td>
                            <td class="px-3 py-1.5">{{ $user->deleted_at ?? '-' }}</td>
                            <td class="px-3 py-1.5">{{ $user->deleted_at ? 'Inactive' : 'Active' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($prod2AllUsers->hasPages())
            <div class="px-4 py-2 border-t border-gray-200">
                {{ $prod2AllUsers->links('pagination::tailwind') }}
            </div>
            @endif

            <div class="p-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">All Users</div>
                    <div class="text-xl font-bold">{{ $prod2AllUsers->total() }}</div>
                </div>
                <div class="bg-green-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">Active Users</div>
                    <div class="text-xl font-bold text-green-700">{{ $prod2ActiveCount }}</div>
                </div>
                <div class="bg-red-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">Inactive Users</div>
                    <div class="text-xl font-bold text-red-700">{{ $prod2InactiveUsers->count() }}</div>
                </div>
            </div>
        </div>

        {{-- Step 2: Access user table from vprod_2 --}}
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-4 border-b border-gray-200 bg-purple-50">
                <h2 class="text-lg font-semibold text-purple-800">Step 2: Access user table from vprod_2</h2>
            </div>

            <div class="p-4 border-b border-gray-200">
                <h3 class="font-medium text-gray-700">All Users</h3>
                <p class="text-sm text-gray-500">Total: {{ $vprod2AllUsers->total() }} (Active: {{ $vprod2ActiveUsers->count() }}, Inactive: {{ $vprod2InactiveUsers->count() }})</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left w-10">SN</th>
                            <th class="px-3 py-2 text-left">ID</th>
                            <th class="px-3 py-2 text-left">Username</th>
                            <th class="px-3 py-2 text-left">First Name</th>
                            <th class="px-3 py-2 text-left">Last Name</th>
                            <th class="px-3 py-2 text-left">Email</th>
                            <th class="px-3 py-2 text-left">Deleted At</th>
                            <th class="px-3 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vprod2AllUsers as $user)
                        <tr class="border-t border-gray-200 {{ $user->deleted_at ? 'bg-red-50' : '' }}">
                            <td class="px-3 py-1.5 text-gray-400">{{ ($vprod2AllUsers->currentPage() - 1) * $vprod2AllUsers->perPage() + $loop->iteration }}</td>
                            <td class="px-3 py-1.5">{{ $user->id }}</td>
                            <td class="px-3 py-1.5 font-medium">{{ $user->username }}</td>
                            <td class="px-3 py-1.5">{{ $user->first_name }}</td>
                            <td class="px-3 py-1.5">{{ $user->last_name }}</td>
                            <td class="px-3 py-1.5">{{ $user->email }}</td>
                            <td class="px-3 py-1.5">{{ $user->deleted_at ?? '-' }}</td>
                            <td class="px-3 py-1.5">{{ $user->deleted_at ? 'Inactive' : 'Active' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($vprod2AllUsers->hasPages())
            <div class="px-4 py-2 border-t border-gray-200">
                {{ $vprod2AllUsers->links('pagination::tailwind') }}
            </div>
            @endif

            <div class="p-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">All Users</div>
                    <div class="text-xl font-bold">{{ $vprod2AllUsers->total() }}</div>
                </div>
                <div class="bg-green-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">Active Users</div>
                    <div class="text-xl font-bold text-green-700">{{ $vprod2ActiveCount }}</div>
                </div>
                <div class="bg-red-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">Inactive Users</div>
                    <div class="text-xl font-bold text-red-700">{{ $vprod2InactiveUsers->count() }}</div>
                </div>
            </div>
        </div>

        {{-- Step 3: Active users from vprod_2 not in prod_2 (unique by username) --}}
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-4 border-b border-gray-200 bg-orange-50">
                <h2 class="text-lg font-semibold text-orange-800">Step 3: Active Users from vprod_2 (excluding prod_2 duplicates)</h2>
                <p class="text-sm text-orange-700">Active vprod_2 users whose username does not exist in prod_2 — {{ $vprod2UniqueActiveUsers->total() }} users</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left w-10">SN</th>
                            <th class="px-3 py-2 text-left">ID</th>
                            <th class="px-3 py-2 text-left">Username</th>
                            <th class="px-3 py-2 text-left">First Name</th>
                            <th class="px-3 py-2 text-left">Last Name</th>
                            <th class="px-3 py-2 text-left">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vprod2UniqueActiveUsers as $user)
                        <tr class="border-t border-gray-200">
                            <td class="px-3 py-1.5 text-gray-400">{{ ($vprod2UniqueActiveUsers->currentPage() - 1) * $vprod2UniqueActiveUsers->perPage() + $loop->iteration }}</td>
                            <td class="px-3 py-1.5">{{ $user->id }}</td>
                            <td class="px-3 py-1.5 font-medium">{{ $user->username }}</td>
                            <td class="px-3 py-1.5">{{ $user->first_name }}</td>
                            <td class="px-3 py-1.5">{{ $user->last_name }}</td>
                            <td class="px-3 py-1.5">{{ $user->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($vprod2UniqueActiveUsers->hasPages())
            <div class="px-4 py-2 border-t border-gray-200">
                {{ $vprod2UniqueActiveUsers->links('pagination::tailwind') }}
            </div>
            @endif
        </div>

        {{-- Step 4: Merged list of active users from prod_2 and unique vprod_2 --}}
        <div class="bg-white rounded-lg shadow mb-8 border-l-4 border-green-600">
            <div class="p-4 border-b border-gray-200 bg-green-50">
                <h2 class="text-lg font-semibold text-green-800">Step 4: Merged Active Users (prod_2 + unique vprod_2)</h2>
                <p class="text-sm text-green-700">prod_2 active: {{ $prod2ActiveCount }} + vprod_2 unique active: {{ $vprod2UniqueActiveUsers->total() }} = Total: {{ $mergedActiveCount }}</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left w-10">SN</th>
                            <th class="px-4 py-2 text-left">Username</th>
                            <th class="px-4 py-2 text-left">First Name</th>
                            <th class="px-4 py-2 text-left">Last Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Source</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mergedActiveUsers as $user)
                            @php $source = in_array($user->username, $prod2ActiveUsers->pluck('username')->toArray()) ? 'prod_2' : 'vprod_2'; @endphp
                            <tr class="border-t border-gray-200">
                                <td class="px-4 py-2 text-gray-400">{{ ($mergedActiveUsers->currentPage() - 1) * $mergedActiveUsers->perPage() + $loop->iteration }}</td>
                                <td class="px-4 py-2 font-medium">{{ $user->username }}</td>
                                <td class="px-4 py-2">{{ $user->first_name }}</td>
                                <td class="px-4 py-2">{{ $user->last_name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium {{ $source === 'prod_2' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $source }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($mergedActiveUsers->hasPages())
            <div class="px-4 py-2 border-t border-gray-200">
                {{ $mergedActiveUsers->links('pagination::tailwind') }}
            </div>
            @endif
        </div>
    </div>
</body>
</html>
