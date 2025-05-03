<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Photo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure photo is less than 2MB') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updatePhoto') }}" class="mt-6 space-y-6" enctype='multipart/form-data'>
        @csrf
        @method('PATCH')

        <div>
            <x-input-label for="update_photo" :value="__('Upload New Photo')" />
            <img src="{{ asset('storage/photos/'. $photo)}}" class="w-20 h-full object-cover" alt="Employee Photo">
            <x-text-input id="update_photo" name="photo" type="file" class="mt-1 block w-full" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
