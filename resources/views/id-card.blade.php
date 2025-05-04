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

                    <!-- Print or Apply Button -->
                    @if (!auth()->user()->isAdmin && auth()->user()->card_approve_status !== 'approved')
                        @if (auth()->user()->card_approve_status != 'approved' && auth()->user()->card_apply_status != 'applied')
                            <a href="{{ route('apply-for-card') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 print:hidden">
                                Apply for Card
                            </a>
                        @else
                            <a href="#"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 print:hidden">
                                Wait for the approval of admin
                            </a>
                        @endif
                    @else
                        <a href="{{ route('print-id-card') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 print:hidden">
                            Print your Card
                        </a>
                    @endif
                    <div class="text-white p-2">
                        Note: You have to fill all the details in your profile to apply and print your ID Card
                    </div>
                    <div
                        class="mt-4 id-card w-[85.6mm] h-[54mm] bg-white rounded-lg shadow-xl overflow-hidden relative border-2 border-gray-200">
                        <!-- Security Background Pattern -->
                        <div
                            class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTYiIGhlaWdodD0iMTYiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTAgMGgxNnYxNkgweiIgZmlsbD0ibm9uZSIvPjxwYXRoIGQ9Ik04IDBMMCA4aDh6bTggOGwtOCA4Vjh6IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9Ii4wNSIvPjwvc3ZnPg==')]">
                        </div>

                        <!-- Main Content -->
                        <div class="flex h-full">
                            <!-- Left Side -->
                            <div
                                class="w-1/3 bg-gradient-to-b from-blue-600 to-blue-500 p-1.5 flex flex-col items-center justify-between">
                                <!-- Company Logo -->
                                <img src="{{ asset('images/company-logo.png') }}"
                                    class="w-8 h-8 mb-1 filter brightness-0 invert">

                                <!-- Employee Photo -->
                                <div class="w-16 h-16 rounded border-2 border-white shadow-sm overflow-hidden">
                                    <img src="{{ asset('storage/photos/' . auth()->user()->photo) }}"
                                        class="w-full h-full object-cover" alt="Employee Photo">
                                </div>

                                <!-- Barcode -->
                                <div class="w-full px-1">
                                    <div class="h-6 bg-white/90 rounded-sm flex items-center justify-center">
                                        <span class="text-[5px] font-mono tracking-tighter">Barcode</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side -->
                            <div class="w-2/3 p-1.5 flex flex-col justify-between">
                                <!-- Header -->
                                <div class="mb-1">
                                    <h1 class="text-[8px] font-bold text-blue-800 uppercase tracking-wide">ACME
                                        Corporation
                                    </h1>
                                    <p class="text-[5px] text-gray-600">Authorized Employee Identification</p>
                                </div>

                                <!-- Details -->
                                <div class="space-y-0.5">
                                    <div>
                                        <p class="text-[5px] text-gray-500">Full Name</p>
                                        <p class="text-[7px] font-bold"></p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-x-2">
                                        <div>
                                            <p class="text-[5px] text-gray-500">ID</p>
                                            <p class="text-[6px] font-mono text-blue-700"></p>
                                        </div>
                                        <div>
                                            <p class="text-[5px] text-gray-500">Department</p>
                                            <p class="text-[6px] font-semibold"></p>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-x-2">
                                        <div>
                                            <p class="text-[5px] text-gray-500">Date of Birth</p>
                                            <p class="text-[6px] font-mono text-blue-700"></p>
                                        </div>
                                        <div>
                                            <p class="text-[5px] text-gray-500">Address</p>
                                            <p class="text-[6px] font-semibold"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="mt-1 border-t border-gray-200 pt-0.5">
                                    <div class="flex justify-between items-center">
                                        <div class="text-[5px] text-gray-600">
                                            Valid:
                                        </div>
                                        <!-- QR Code -->
                                        <div class="w-10 h-10 p-0.5 bg-white border border-gray-200 rounded-sm">
                                            <img src="" class="w-full h-full" alt="QR Code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hologram Effect -->
                        <div
                            class="absolute top-1 right-1 w-8 h-8 bg-gradient-to-tr from-transparent via-white/30 to-transparent rounded-full">
                        </div>
                    </div>
                </div>





                @if (Auth::user()->isAdmin)
                    <div class="flex">


                        <form action="{{ route('generate-id-card') }}" class="max-w-sm mx-auto mt-3 border p-4"
                            method="POST">
                            @csrf
                            <div class="mb-5 mt-1">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Full Name</label>
                                <input type="text" id="name" name="name"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                                    equired />
                            </div>
                            <div class="mb-5 mt-1">
                                <label for="address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Address</label>
                                <input type="text" id="address" name="address"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                                    required />
                            </div>
                            <div class="mb-5 mt-1">
                                <label for="dob"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    DOB</label>
                                <input type="date" id="dob" name="dob"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                                    required />
                            </div>
                            <div class="mb-5 mt-1">
                                <label for="department"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Department</label>
                                <input type="text" id="department" name="department"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                                    required />
                            </div>
                            <div class="mb-5 mt-1">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Upload photo</label>
                                <input type="file" id="name" name="photo"
                                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
                                    equired />
                            </div>
                            <div class="flex items-start mb-5 mt-2">
                                <div class="flex items-center h-5">
                                    <input id="terms" type="checkbox" value=""
                                        class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                                        required />
                                </div>
                                <label for="terms"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">I
                                    agree
                                    with the <a href="#"
                                        class="text-blue-600 hover:underline dark:text-blue-500">terms
                                        and
                                        conditions</a></label>
                            </div>
                            <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 print:hidden mt-2">Generate
                                New
                                Card</button>
                        </form>

                    </div>
                @endif

            </div>

            @if (auth()->user()->isAdmin)
                <div
                    class="mt-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center p-2">
                    <div class="p-6 w-full h-full text-gray-900 dark:text-gray-100">

                        <h2 class="font-semibold text-xl mb-5 text-gray-800 dark:text-gray-200 leading-tight">
                            {{ __('Edit Card Details') }}
                        </h2>

                        <div class="form-group w-full min-h-[300px] grid grid-cols-1 md:grid-cols-2 gap-4">
                            <form action="/update-card-details" method="POST">
                                @csrf
                                @method('PUT')


                                <div class="card-detail-container w-full p-2">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Card
                                        Logo</label>
                                    <input type="file" id="card_logo" name="name"
                                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" />
                                </div>

                                <div class="card-detail-container w-full flex flex-col p-2">
                                    <label for="name"
                                        class="block mb-3 text-sm font-medium text-gray-900 dark:text-white">What to
                                        include in QR code of ID Card?</label>

                                    <div class="items-container">

                                        <div class="flex items-center">
                                            <input hidden checked id="hidden-checked-checkbox" name="select_id"
                                                type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="hidden-checked-checkbox"
                                                class="ms-2 text-sm font-medium text-gray-400 dark:text-gray-500">Id</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="checkbox" name="select_name" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="checkbox" name="select_company_name" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Company
                                                Name</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="checkbox" name="select_expiry_date" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Expiry
                                                Date</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="checkbox" name="select_email" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="checkbox" name="select_address" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Address</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="checkbox" name="select_department" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Department</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input id="checkbox" name="select_dob" type="checkbox"
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox"
                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Date
                                                of
                                                Birth</label>
                                        </div>
                                    </div>


                                </div>

                                {{-- card custom message will open when user ticks custom message --}}
                                <div class="card-detail-container w-full p-2">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Custom Message to be placed in QR code (if required)</label>
                                    <input type="text" id="card_logo" name="card_custom_message"
                                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" />
                                </div>

                                <div class="card-detail-container w-full p-2">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Card
                                        Expiry Date</label>
                                    <input type="date" id="card_logo" name="card_expiry_date"
                                        class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light" />
                                </div>


                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 print:hidden mt-2">
                                    Save Changes
                                </button>

                            </form>


                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
