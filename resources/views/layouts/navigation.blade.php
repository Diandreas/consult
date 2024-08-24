<nav x-data="{ open: false }" class="bg-indigo-700 border-b border-indigo-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-white font-bold text-xl">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-indigo-200 hover:text-white hover:bg-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('consultation_requests.indexByUser')" :active="request()->routeIs('consultation_requests.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                        {{ __('My Requests') }}
                    </x-nav-link>

                    @if(auth()->user()->user_types_id == 1 || auth()->user()->user_types_id == 2)
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-indigo-200 hover:text-white hover:bg-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('user_types.index')" :active="request()->routeIs('user_types.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            {{ __('User Types') }}
                        </x-nav-link>
                        <x-nav-link :href="route('priorities.index')" :active="request()->routeIs('priorities.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            {{ __('Priorities') }}
                        </x-nav-link>
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            {{ __('Categories') }}
                        </x-nav-link>
                        <x-nav-link :href="route('consultation_requests.index')" :active="request()->routeIs('consultation_requests.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                            {{ __('Consultation Requests') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600 focus:text-white transition duration-150 ease-in-out px-3 py-2 rounded-md">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-700 hover:bg-indigo-100">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                             class="text-gray-700 hover:bg-indigo-100">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-indigo-200 hover:text-white hover:bg-indigo-600 focus:outline-none focus:bg-indigo-600 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-indigo-600">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @if(auth()->user()->user_types_id == 1 || auth()->user()->user_types_id == 2)
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user_types.index')" :active="request()->routeIs('user_types.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('User Types') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('priorities.index')" :active="request()->routeIs('priorities.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Priorities') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Categories') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('consultation_requests.index')" :active="request()->routeIs('consultation_requests.*')" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Consultation Requests') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-indigo-800">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-indigo-200">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-indigo-200 hover:text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                           class="text-indigo-200 hover:text-white hover:bg-indigo-700 block px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
