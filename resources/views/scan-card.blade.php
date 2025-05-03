<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ID card') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center p-2">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Click on the button below to scan your ID card. You can also scan any QR code here.
                    <div class="flex justify-center mt-4">
                        <a href="{{ route('scan.qrcode') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring focus:ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                            Scan ID Card
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center p-2">
                <div class="p-6 text-gray-900 w-full dark:text-gray-100">

                    @if (array_key_exists('text', $data) && !$data['text'] && !$type)
                        All card details will appear here
                    @endif

                    @if ($type === 'wifi')
                        <div class="bg-black text-white p-4 rounded-lg shadow border border-gray-200">
                            <h3 class="text-xl font-semibold mb-3">WiFi Credentials</h3>
                            <div class="mb-2"><strong>SSID:</strong> {{ $data['ssid'] }}</div>
                            <div class="mb-2"><strong>Encryption:</strong> {{ $data['encryption'] }}</div>
                            <div class="mb-2"><strong>Password:</strong> {{ $data['password'] }}</div>
                            <div class="mb-2"><strong>Hidden:</strong> {{ $data['hidden'] }}</div>
                        </div>
                    @elseif ($type === 'id-card')
                        <div class="w-full rounded-lg shadow border border-gray-200 p-6">
                            <h3 class="text-2xl font-semibold text-white mb-6">User Details</h3>
                            <img src="{{ asset('storage/photos/'. $data['photo'])}}" class="m-2 w-20 h-full object-cover" alt="Employee Photo">
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-2 gap-6">
                                @foreach (['name', 'email', 'address', 'dob', 'department', 'role'] as $field)
                                    <div class="space-y-1 {{ in_array($field, ['address']) ? 'md:col-span-2' : '' }}">
                                        <label class="block text-sm font-medium text-gray-400">
                                            {{ ucfirst($field) }}
                                        </label>
                                        <div class="p-3 bg-gray-50 rounded border border-gray-200 text-gray-700">
                                            {{ $data[$field] ?? 'Not provided' }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @elseif ($type === 'json')
                        <div class="bg-black text-white p-4 rounded-lg shadow border border-gray-200">
                            <h3 class="text-xl font-semibold mb-3">QR Data (JSON)</h3>
                            @foreach ($data as $key => $value)
                                <div class="mb-2">
                                    <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                                </div>
                            @endforeach
                        </div>
                    @elseif ($type === 'text')
                        <div class="bg-black text-white p-4 rounded-lg shadow border border-gray-200">
                            <h3 class="text-xl font-semibold mb-3">Plain Text</h3>
                            <p class="text-lg">{{ $data['text'] }}</p>
                        </div>
                    @else
                        @if ($data['text'] || $type)
                            <p class="text-red-500">Unknown QR code type.</p>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
