<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Card Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (count($cards)==0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center p-2">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        "No card requests available at the moment."
                    </div>
                </div>
            @else
                <div class="w-full h-full bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center p-2">
                    <div class="p-6 w-full h-full text-gray-900 dark:text-gray-100">
                        <table class="w-full h-full divide-y divide-gray-800">
                            <thead class="bg-gray-950">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Card Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DOB</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>  
                                </tr>
                            </thead>
                            <tbody class="bg-black divide-y divide-gray-800">
                                @foreach ($cards as $card)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $card['name'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $card['formatted_created_at'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($card['photo'])
                                                <img src="{{ asset('storage/photos/' . $card['photo']) }}" alt="Card Photo" class="w-24 h-full object-cover">
                                            @else
                                                No Photo
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $card['formatted_dob'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $card['address'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('approve-card', $card['id']) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-green-700 print:hidden">Approve</a>
                                            <a href="{{ route('reject-card', $card['id']) }}" class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-red-700 print:hidden">Reject</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            {{-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex justify-center p-2">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    "We are currently working on this feature and will be available in the future!"
                </div>
            </div> --}}

        </div>
    </div>
</x-app-layout>