<nav class="bg-gray-900 text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-14">
            <a href="/" class="font-bold text-lg tracking-tight">Migration Data Check</a>

            <div class="flex items-center gap-2">
                <a href="/" class="px-3 py-1.5 text-sm rounded hover:bg-gray-700 transition">Home</a>

                {{-- Comparisons dropdown --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-1 px-3 py-1.5 text-sm rounded hover:bg-gray-700 transition">
                        Compare Tables
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-64 bg-white text-gray-800 rounded-lg shadow-xl max-h-96 overflow-y-auto z-50" style="display: none;">
                        <div class="p-2 space-y-0.5">
                            <a href="/compare-users" class="block px-3 py-2 text-sm rounded hover:bg-blue-50 font-medium">Users</a>
                            <hr class="my-1 border-gray-200">

                            <div class="text-xs font-semibold text-gray-500 px-3 pt-1 pb-0.5 uppercase tracking-wider">Core</div>
                            <a href="/compare-calendar" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Calendar</a>
                            <a href="/compare-forms" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Forms</a>
                            <a href="/compare-project" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Project</a>
                            <a href="/compare-project-group" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Project Group</a>
                            <a href="/compare-client" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Client</a>
                            <a href="/compare-contact" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Contact</a>

                            <hr class="my-1 border-gray-200">
                            <div class="text-xs font-semibold text-gray-500 px-3 pt-1 pb-0.5 uppercase tracking-wider">Result Codes</div>
                            <a href="/compare-result-code" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Result Code</a>
                            <a href="/compare-result-code-description" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Result Code Description</a>
                            <a href="/compare-result-code-outcome" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Result Code Outcome</a>
                            <a href="/compare-result-code-type" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Result Code Type</a>
                            <a href="/compare-rights" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Rights</a>

                            <hr class="my-1 border-gray-200">
                            <div class="text-xs font-semibold text-gray-500 px-3 pt-1 pb-0.5 uppercase tracking-wider">Teams & Groups</div>
                            <a href="/compare-teams" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Teams</a>
                            <a href="/compare-user-groups" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">User Groups</a>

                            <hr class="my-1 border-gray-200">
                            <div class="text-xs font-semibold text-gray-500 px-3 pt-1 pb-0.5 uppercase tracking-wider">Communication</div>
                            <a href="/compare-email" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Email</a>
                            <a href="/compare-email-template" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Email Template</a>
                            <a href="/compare-calls" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Calls</a>
                            <a href="/compare-transcription" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Transcription</a>
                            <a href="/compare-media" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Media</a>

                            <hr class="my-1 border-gray-200">
                            <div class="text-xs font-semibold text-gray-500 px-3 pt-1 pb-0.5 uppercase tracking-wider">Configuration</div>
                            <a href="/compare-attributes" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Attributes</a>
                            <a href="/compare-attribute-forms" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Attribute Forms</a>
                            <a href="/compare-property" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Property</a>
                            <a href="/compare-settings" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Settings</a>
                            <a href="/compare-types" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Types</a>
                            <a href="/compare-account-database" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Account Database</a>
                            <a href="/compare-app-setting" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">App Setting</a>
                            <a href="/compare-views" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Views</a>
                            <a href="/compare-field" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Field</a>
                            <a href="/compare-refresh-tokens" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">Refresh Tokens</a>
                            <a href="/compare-otp" class="block px-3 py-1.5 text-sm rounded hover:bg-blue-50">OTP</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
