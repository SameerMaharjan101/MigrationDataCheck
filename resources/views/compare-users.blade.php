<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Comparison: prod_2 vs vprod_2</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    @include('partials.navbar')
    <div class="max-w-7xl mx-auto p-6 pt-6">
        <h1 class="text-2xl font-bold mb-6">User Comparison: prod_2 vs vprod_2</h1>

        {{-- Step 1: Access user table from prod_2 --}}
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="p-4 border-b border-gray-200 bg-blue-50">
                <h2 class="text-lg font-semibold text-blue-800">Step 1: Access user table from prod_2</h2>
            </div>

            <div class="p-4 border-b border-gray-200">
                <h3 class="font-medium text-gray-700">All Users</h3>
                <p class="text-sm text-gray-500">Total: {{ $prod2AllUsers->count() }} (Active: {{ $prod2ActiveUsers->count() }}, Inactive: {{ $prod2InactiveUsers->count() }})</p>
            </div>
            <div class="overflow-x-auto max-h-80 overflow-y-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
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

            <div class="p-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">All Users</div>
                    <div class="text-xl font-bold">{{ $prod2AllUsers->count() }}</div>
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
                <p class="text-sm text-gray-500">Total: {{ $vprod2AllUsers->count() }} (Active: {{ $vprod2ActiveUsers->count() }}, Inactive: {{ $vprod2InactiveUsers->count() }})</p>
            </div>
            <div class="overflow-x-auto max-h-80 overflow-y-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
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

            <div class="p-4 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 rounded p-3 text-center">
                    <div class="text-xs text-gray-500">All Users</div>
                    <div class="text-xl font-bold">{{ $vprod2AllUsers->count() }}</div>
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
                <p class="text-sm text-orange-700">Active vprod_2 users whose username does not exist in prod_2 — {{ $vprod2UniqueActiveUsers->count() }} users</p>
            </div>
            <div class="overflow-x-auto max-h-80 overflow-y-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
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
        </div>

        {{-- Step 4: Merged list of active users from prod_2 and unique vprod_2 --}}
        <div class="bg-white rounded-lg shadow mb-8 border-l-4 border-green-600">
            <div class="p-4 border-b border-gray-200 bg-green-50">
                <h2 class="text-lg font-semibold text-green-800">Step 4: Merged Active Users (prod_2 + unique vprod_2)</h2>
                <p class="text-sm text-green-700">prod_2 active: {{ $prod2ActiveCount }} + vprod_2 unique active: {{ $vprod2UniqueActiveUsers->count() }} = Total: {{ $mergedActiveCount }}</p>
            </div>
            <div class="overflow-x-auto max-h-96 overflow-y-auto">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
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
        </div>
    </div>
</body>
</html>
