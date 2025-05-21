@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg border border-gray-300 max-w-4xl mx-auto" id="printableArea">
            <!-- En-tête -->
            <div class="border-b-2 border-gray-300 p-6 flex justify-between items-center bg-gray-900 text-white">
                <div class="flex items-center">
                    <div>
                        <h1 class="text-2xl font-bold">{{ __('ARCHIVE NATIONALE DU CAMEROUN') }}</h1>
                        <p class="text-sm">{{ __('B.P. : 1053 Rue 317, quartier du Lac, Yaoundé III') }}</p>
                        <p class="text-sm">{{ __('(+237) 222 226 791') }}</p>
                    </div>
                    <x-application-logo class="h-16 w-auto mr-4"></x-application-logo>
                </div>
                <div class="text-right">
                    <p class="text-lg font-semibold">{{ __('Demande de Consultation d\'archives') }}</p>
                    <p class="text-md">{{ __('N° :') }} {{ str_pad($consultationRequest->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm">{{ __('Date :') }} {{ now()->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Contenu du document -->
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4 text-center">{{ __('Détails de la Demande de Consultation') }}</h2>

                <table class="w-full mb-6">
                    <tr>
                        <td class="font-semibold w-1/3">{{ __('Statut :') }}</td>
                        <td>{{ $consultationRequest->status }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">{{ __('Niveau de priorité :') }}</td>
                        <td>{{ $consultationRequest->priority->name }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">{{ __('Concernant la période :') }}</td>
                        <td>{{ __('Du') }} {{ $consultationRequest->date_start }} {{ __('au') }} {{ $consultationRequest->date_end }}</td>
                    </tr>
                </table>

                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">{{ __('Description :') }}</h3>
                    <div class="border border-gray-300 p-3 bg-gray-50">{!! $consultationRequest->description !!}</div>
                </div>

                @if($consultationRequest->document)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-2">{{ __('Document de la bibliothèque associé :') }}</h3>
                    <div class="border border-gray-300 p-3 bg-gray-50">
                        <table class="w-full">
                            <tr>
                                <td class="font-semibold w-1/3">{{ __('Titre :') }}</td>
                                <td>{{ $consultationRequest->document->title }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">{{ __('Type de document :') }}</td>
                                <td>{{ $consultationRequest->document->documentType->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">{{ __('Date :') }}</td>
                                <td>{{ \Carbon\Carbon::parse($consultationRequest->document->date)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">{{ __('Description :') }}</td>
                                <td>{{ $consultationRequest->document->description }}</td>
                            </tr>
                            @if($consultationRequest->document->material_condition)
                            <tr>
                                <td class="font-semibold">{{ __('État matériel :') }}</td>
                                <td>{{ $consultationRequest->document->material_condition }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- Pied de page -->
            <div class="border-t border-gray-300 p-4 text-sm text-gray-600 text-center bg-gray-100">
                <p>{{ __('Ce document est confidentiel et destiné uniquement à usage interne.') }}</p>
            </div>
        </div>

        <!-- Boutons d'action (hors de la zone imprimable) -->
        <div class="mt-6 flex justify-between items-center max-w-4xl mx-auto">
            <button onclick="window.history.back()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Retour') }}
            </button>
            <div>
                <button onclick="printDocument()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                    {{ __('Imprimer') }}
                </button>
                @if(auth()->user()->user_types_id == 1)
                    <a href="{{ route('consultation_requests.edit', $consultationRequest->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">{{ __('Modifier') }}</a>
                    <form action="{{ route('consultation_requests.destroy', $consultationRequest->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">{{ __('Supprimer') }}</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        function printDocument() {
            var printContents = document.getElementById("printableArea").innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
