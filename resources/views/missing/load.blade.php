<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <div class="flex items-center">
                <div class="pr-3 text-lg cursor-pointer text-gray-800 dark:text-gray-200">
                    <a onclick="window.history.back();"><i class="fa fa-angle-left"></i></a>
                </div>

                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Importa traduzioni completate') }}
                </h2>
            </div>


        </div>
    </x-slot>

    <div class="py-4 flex px-32">
        <div class="flex-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex-1 my-6 p-5 ">

                <form method="post" action="{{ route('missing.upload') }}" enctype="multipart/form-data"
                    class="dropzone cursor-pointer bg-indigo-50 border border-dashed border-indigo-300 rounded-md w-full h-48 align-middle text-center p-12"
                    id="dropzone">
                    @csrf
                    <div class="dz-message text-center">
                        <div class=" text-4xl pb-4">
                            <i class="fa-regular fa-file-import"></i>
                        </div>
                        Clicca o trascina qui il file con le traduzioni tradotte
                        <p class=" text-sm text-gray-400">
                            Sono consentiti solo file .csv, .xls, .xlsx
                        </p>
                    </div>
                </form>
                <script type="text/javascript">
                    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                    Dropzone.options.dropzone = {
                        paramName: "file",
                        maxFilesize: 30, // MB
                        acceptedFiles: ".csv,.xls,.xlsx",
                        queuecomplete: function(file, response) {
                            console.log(file + ' ' + response);
                            location.reload();
                        }
                    };
                </script>

            </div>
        </div>
    </div>
</x-app-layout>
