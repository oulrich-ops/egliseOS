<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#123c35] text-amber-300"><i data-lucide="cross" class="h-5 w-5 stroke-[3]"></i></span>
                        <span class="hidden text-base font-bold tracking-tight text-slate-800 sm:inline">ÉgliseOS</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')">
                        {{ __('Membres') }}
                    </x-nav-link>
                    <x-nav-link :href="route('structures.index')" :active="request()->routeIs('structures.*')">
                        {{ __('Structures') }}
                    </x-nav-link>
                    <x-nav-link :href="route('settings.positions.index')" :active="request()->routeIs('settings.*')">
                        {{ __('Paramètres') }}
                    </x-nav-link>
                </div>
            </div>

            @if (Auth::user()->is_platform_admin)
                <div class="hidden items-center sm:flex sm:-my-px sm:ms-8">
                    <x-nav-link :href="route('admin.tenants.index')" :active="request()->routeIs('admin.*')">
                        {{ __('Demandes') }}
                    </x-nav-link>
                </div>
            @endif

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="mr-4 flex items-center gap-1 rounded-lg border border-slate-200 bg-slate-50 p-1 text-xs font-bold">
                    <a href="{{ route('locale.update', 'fr') }}" class="rounded-md px-2 py-1 {{ app()->getLocale() === 'fr' ? 'bg-[#123c35] text-white' : 'text-slate-500 hover:text-slate-900' }}">FR</a>
                    <a href="{{ route('locale.update', 'en') }}" class="rounded-md px-2 py-1 {{ app()->getLocale() === 'en' ? 'bg-[#123c35] text-white' : 'text-slate-500 hover:text-slate-900' }}">EN</a>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <i data-lucide="chevron-down" class="h-4 w-4"></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <i data-lucide="menu" :class="{'hidden': open, 'inline-flex': ! open }" class="h-6 w-6"></i>
                    <i data-lucide="x" :class="{'hidden': ! open, 'inline-flex': open }" class="hidden h-6 w-6"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')">
                {{ __('Membres') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('structures.index')" :active="request()->routeIs('structures.*')">
                {{ __('Structures') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('settings.positions.index')" :active="request()->routeIs('settings.*')">
                {{ __('Paramètres') }}
            </x-responsive-nav-link>
        </div>

        @if (Auth::user()->is_platform_admin)
            <div class="border-t border-gray-200 pt-2">
                <x-responsive-nav-link :href="route('admin.tenants.index')" :active="request()->routeIs('admin.*')">
                    {{ __('Demandes') }}
                </x-responsive-nav-link>
            </div>
        @endif

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex gap-2 px-4 py-3 text-xs font-bold">
                <a href="{{ route('locale.update', 'fr') }}" class="rounded-md border px-3 py-1 {{ app()->getLocale() === 'fr' ? 'border-[#123c35] bg-[#123c35] text-white' : 'border-slate-300 text-slate-500' }}">FR</a>
                <a href="{{ route('locale.update', 'en') }}" class="rounded-md border px-3 py-1 {{ app()->getLocale() === 'en' ? 'border-[#123c35] bg-[#123c35] text-white' : 'border-slate-300 text-slate-500' }}">EN</a>
            </div>
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
