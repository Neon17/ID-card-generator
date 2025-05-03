<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee ID Card</title>
    @vite(['resources/css/app.css'])
    <style>
        /* Screen view scaling */
        @media screen {
            .id-card-container {
                transform: scale(1.5);
                transform-origin: center;
                margin: 2rem auto;
            }
        }

        /* Print sizing */
        @media print {
            @page {
                size: 85.6mm 54mm !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            body {
                margin: 0 !important;
                padding: 0 !important;
            }
            .id-card {
                width: 85.6mm !important;
                height: 54mm !important;
                box-shadow: none !important;
                border: none !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <!-- Print Button -->
    <button onclick="window.print()" class="fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 print:hidden">
        Print ID Card
    </button>

    <!-- ID Card Container -->
    <div class="id-card-container">
        <div class="id-card w-[85.6mm] h-[54mm] bg-white rounded-lg shadow-xl overflow-hidden relative border-2 border-gray-200">
            <!-- Security Background Pattern -->
            <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgMGgxNnYxNkgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik04IDBMMCA4aDh6bTggOGwtOCA4Vjh6IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9Ii4wNSIvPjwvc3ZnPg==')]"></div>

            <!-- Main Content -->
            <div class="flex h-full">
                <!-- Left Side -->
                <div class="w-1/3 bg-gradient-to-b from-blue-600 to-blue-500 p-1.5 flex flex-col items-center justify-between">
                    <!-- Company Logo -->
                    <img src="{{ asset('images/company-logo.png') }}" class="w-8 h-8 mb-1 filter brightness-0 invert">

                    <!-- Employee Photo -->
                    <div class="w-16 h-16 rounded border-2 border-white shadow-sm overflow-hidden">
                        <img src="{{ $user['photo'] }}" class="w-full h-full object-cover" alt="Employee Photo">
                    </div>

                    <!-- Barcode -->
                    <div class="w-full px-1">
                        <div class="h-6 bg-white/90 rounded-sm flex items-center justify-center">
                            <span class="text-[5px] font-mono tracking-tighter">{{ $user['barcode'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="w-2/3 p-1.5 flex flex-col justify-between">
                    <!-- Header -->
                    <div class="mb-1">
                        <h1 class="text-[8px] font-bold text-blue-800 uppercase tracking-wide">ACME Corporation</h1>
                        <p class="text-[5px] text-gray-600">Authorized Employee Identification</p>
                    </div>

                    <!-- Details -->
                    <div class="space-y-0.5">
                        <div>
                            <p class="text-[5px] text-gray-500">Full Name</p>
                            <p class="text-[7px] font-bold">{{ $user['full_name'] }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <p class="text-[5px] text-gray-500">ID</p>
                                <p class="text-[6px] font-mono text-blue-700">{{ $user['id_number'] }}</p>
                            </div>
                            <div>
                                <p class="text-[5px] text-gray-500">Department</p>
                                <p class="text-[6px] font-semibold">{{ $user['department'] }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-x-2">
                            <div>
                                <p class="text-[5px] text-gray-500">Date of Birth</p>
                                <p class="text-[6px] font-semibold">{{ $user['dob'] }}</p>
                            </div>
                            <div>
                                <p class="text-[5px] text-gray-500">Address</p>
                                <p class="text-[6px] font-mono text-blue-700">{{ $user['address'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-1 border-t border-gray-200 pt-0.5">
                        <div class="flex justify-between items-center">
                            <div class="text-[5px] text-gray-600">
                                Valid: {{ $user["valid_from"] }} - {{ $user["valid_to"] }}
                            </div>
                            <!-- QR Code -->
                            <div class="w-10 h-10 p-0.5 bg-white border border-gray-200 rounded-sm">
                                <img src="{{ $user['qr_code'] }}" class="w-full h-full" alt="QR Code">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hologram Effect -->
            <div class="absolute top-1 right-1 w-8 h-8 bg-gradient-to-tr from-transparent via-white/30 to-transparent rounded-full"></div>
        </div>
    </div>
</body>
</html>