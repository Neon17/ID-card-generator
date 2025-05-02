<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Department') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Department means field of work, or expertise, or learning') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.updateDepartment') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="department" :value="__('Department')" />
            <x-text-input id="department" name="department" type="text" value={{$department}} class="mt-1 block w-full" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>

    </form>
</section>
