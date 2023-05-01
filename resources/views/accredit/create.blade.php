<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nuovo accredito') }}
            </h2>
            <div>

            </div>
        </div>
    </x-slot>

    <div class="py-6 flex flex-col sm:justify-center items-center bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-xl px-6 py-2 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

            <div class="w-full p-5">
                @if (env('MAIL_HOST', '') == 'smtp.mailtrap.io')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-3 rounded relative"
                        role="alert">
                        <p>
                            <strong class="font-bold">MODALITA' MAILTRAP</strong>
                        </p>
                        <p class="block sm:inline">Le email non saranno inviate a nessun
                            destinatario.</p>
                    </div>
                @endif

                <livewire:create-accredit />
            </div>

        </div>
    </div>
</x-app-layout>
