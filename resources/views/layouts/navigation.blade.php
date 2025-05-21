<nav x-data="{ open: false }" class="bg-vintage-primary border-b vintage-border">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="vintage-header">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                    @if(auth()->user()->user_types_id != 1 && auth()->user()->user_types_id != 2 )
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="vintage-header">
                            {{ __('Home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('consultation_requests.indexByUser')" :active="request()->routeIs('consultation_requests.*')" class="vintage-header">
                            {{ __('Mes demandes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.*')" class="vintage-header">
                            {{ __('Catalogue') }}
                        </x-nav-link>
                    @endif

                    @if(auth()->user()->user_types_id == 1 )
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="vintage-header">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('user_types.index')" :active="request()->routeIs('user_types.*')" class="vintage-header">
                            {{ __('Types d\'utilisateur') }}
                        </x-nav-link>
                        <x-nav-link :href="route('priorities.index')" :active="request()->routeIs('priorities.*')" class="vintage-header">
                            {{ __('Priorités') }}
                        </x-nav-link>
                        <x-nav-link :href="route('consultation_requests.index')" :active="request()->routeIs('consultation_requests.*')" class="vintage-header">
                            {{ __('Demandes de consultation') }}
                        </x-nav-link>
                        <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.*')" class="vintage-header">
                            {{ __('Catalogue') }}
                        </x-nav-link>
                        <x-nav-link :href="route('document-types.index')" :active="request()->routeIs('document-types.*')" class="vintage-header">
                            {{ __('Types de documents') }}
                        </x-nav-link>
                    @endif
                    @if(auth()->user()->user_types_id == 2 )
                        <x-nav-link :href="route('workflow.index')" :active="request()->routeIs('workflow.*')" class="vintage-header">
                            {{ __('Flux de consultation') }}
                        </x-nav-link>
                        <x-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.*')" class="vintage-header">
                            {{ __('Catalogue') }}
                        </x-nav-link>
                        <x-nav-link :href="route('document-types.index')" :active="request()->routeIs('document-types.*')" class="vintage-header">
                            {{ __('Types de documents') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border vintage-border text-sm leading-4 font-medium rounded-md text-gray-800 bg-transparent hover:text-gray-900 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="vintage-header">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();" class="vintage-header">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-amber-900 hover:text-white hover:bg-amber-700 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-vintage-secondary">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                {{ __('Home') }}
            </x-responsive-nav-link>

            @if(auth()->user()->user_types_id == 1 || auth()->user()->user_types_id == 2)
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user_types.index')" :active="request()->routeIs('user_types.*')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Types d\'utilisateur') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('priorities.index')" :active="request()->routeIs('priorities.*')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Priorités') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('consultation_requests.index')" :active="request()->routeIs('consultation_requests.*')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Demandes de consultation') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.*')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Catalogue') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('document-types.index')" :active="request()->routeIs('document-types.*')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Types de documents') }}
                </x-responsive-nav-link>
            @endif
            
            @if(auth()->user()->user_types_id != 1 && auth()->user()->user_types_id != 2)
                <x-responsive-nav-link :href="route('consultation_requests.indexByUser')" :active="request()->routeIs('consultation_requests.indexByUser')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Mes demandes') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('documents.index')" :active="request()->routeIs('documents.*')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Catalogue') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t vintage-border">
            <div class="px-4">
                <div class="font-medium text-base text-gray-900">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-700">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                           class="vintage-header block px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

