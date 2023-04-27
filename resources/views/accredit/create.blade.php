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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                </div>

                <div class="w-full p-5">
                    @if (env('MAIL_HOST', '') == 'smtp.mailtrap.io')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>MODALITA' MAILTRAP:</strong> &nbspLe email non saranno inviate a nessun
                            destinatario.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <livewire:create-accredit />
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
