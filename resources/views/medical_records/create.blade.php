<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Consulta para') }} {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('medical_records.store', $patient) }}">
                        @csrf

                        <!-- Doctor -->
                        <div class="mb-4">
                            <x-input-label for="doctor_id" :value="__('Doctor')" />
                            <select id="doctor_id" name="doctor_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }} - {{ $doctor->specialty }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('doctor_id')" class="mt-2" />
                        </div>

                        <!-- Diagnosis -->
                        <div class="mb-4">
                            <x-input-label for="diagnosis" :value="__('Diagnóstico Fisioterapéutico')" />
                            <textarea id="diagnosis" name="diagnosis" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('diagnosis') }}</textarea>
                            <x-input-error :messages="$errors->get('diagnosis')" class="mt-2" />
                        </div>

                        <!-- Indications -->
                        <div class="mb-4">
                            <x-input-label for="indications" :value="__('Indicaciones')" />
                            <textarea id="indications" name="indications" rows="6" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('indications') }}</textarea>
                            <x-input-error :messages="$errors->get('indications')" class="mt-2" />
                        </div>

                        <!-- Next Appointment -->
                        <div class="mb-4">
                            <x-input-label for="next_appointment_date" :value="__('Próxima Cita (Opcional)')" />
                            <x-text-input id="next_appointment_date" class="block mt-1 w-full" type="date" name="next_appointment_date" :value="old('next_appointment_date')" />
                            <x-input-error :messages="$errors->get('next_appointment_date')" class="mt-2" />
                        </div>

                        <!-- Signature -->
                        <div class="mb-4">
                            <x-input-label for="signature" :value="__('Firma del Doctor')" />
                            <div class="border border-gray-300 rounded-md p-2 bg-gray-50">
                                <canvas id="signature-pad" class="w-full h-40 border border-gray-200 bg-white" width=500 height=200></canvas>
                            </div>
                            <div class="flex justify-between mt-2">
                                <button type="button" id="clear-signature" class="text-sm text-red-600 hover:text-red-800">Borrar Firma</button>
                                <span class="text-xs text-gray-500">Dibuje su firma arriba</span>
                            </div>
                            <input type="hidden" name="signature" id="signature-input">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('patients.history', $patient) }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button id="submit-btn">
                                {{ __('Guardar Consulta') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            var canvas = document.getElementById('signature-pad');
                            var signaturePad = new SignaturePad(canvas);
                            var clearButton = document.getElementById('clear-signature');
                            var submitButton = document.getElementById('submit-btn');
                            var signatureInput = document.getElementById('signature-input');
                            var form = canvas.closest('form');

                            // Adjust canvas ratio
                            function resizeCanvas() {
                                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                                canvas.width = canvas.offsetWidth * ratio;
                                canvas.height = canvas.offsetHeight * ratio;
                                canvas.getContext("2d").scale(ratio, ratio);
                                signaturePad.clear();
                            }
                            window.addEventListener("resize", resizeCanvas);
                            resizeCanvas();

                            clearButton.addEventListener('click', function () {
                                signaturePad.clear();
                            });

                            form.addEventListener('submit', function (e) {
                                if (!signaturePad.isEmpty()) {
                                    signatureInput.value = signaturePad.toDataURL(); // Save as base64
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
