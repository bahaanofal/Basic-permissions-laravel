<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('view-any', App\Model\User::class)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom: 5px;">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{route('users.index')}}">
                        Users Management Page
                    </a>
                </div>
            </div>
            @endcan
            @can('view-any', App\Model\Role::class)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom: 5px;">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{route('roles.index')}}">
                        Roles Management Page
                    </a>
                </div>
            </div>
            @endcan
            @can('view-any', App\Model\Category::class)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg" style="margin-bottom: 5px;">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a href="{{route('categories.index')}}">
                        Categories Management Page
                    </a>
                </div>
            </div>
            @endcan
        </div>
    </div>
</x-app-layout>
