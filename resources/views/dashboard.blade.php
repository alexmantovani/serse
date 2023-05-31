<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-4">

                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="flex my-4 rounded-md border border-gray-300">
                        <!-- Email Address -->
                        <div class="flex w-full">
                            <input
                                class="mr-3 border-0 focus:ring-0 focus:ring-slate-300 focus:outline-none appearance-none w-full  text-slate-900 placeholder-slate-400 rounded-md py-2 pl-3 ring-0"
                                type="text" aria-label="Search" placeholder="Cerca..." value="{{ $search ?? '' }}"
                                name="search" autofocus>
                        </div>

                        <div class=" flex-none items-center p-1">
                            <x-primary-button class="ml-3 h-12 w-12">
                                <i class="fa-sharp fa-solid fa-magnifying-glass"></i>
                            </x-primary-button>
                        </div>

                    </div>
                </form>
            </div>


            @if ($serialNumber)
                <div class="py-5">
                    <div class=" text-2xl font-semibold">
                        {{ $serialNumber->name }}
                    </div>
                    <div class="py-2">
                        <div class="flex justify-between">
                            <div class=" text-2xl">
                                Info varie
                            </div>

                            <div>

                                <div class="text-white rounded-lg bg-red-600 p-5 text-right w-56">
                                    <div class="flex justify-between items-start align-top">
                                        <i class="fa-regular fa-triangle-exclamation text-white text-lg"></i>
                                        <div class="text-6xl font-semibold">
                                            {{ $totalMissing }}
                                        </div>
                                    </div>
                                    <div class=" uppercase text-sm mb-4">
                                        Traduzioni mancanti
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ route('translation.missing', $serialNumber) }}">
                                            <x-danger-button class="w-full justify-center ">
                                                Dettagli
                                            </x-danger-button>
                                        </a>
                                    </div>
                                </div>

                            </div>



                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
