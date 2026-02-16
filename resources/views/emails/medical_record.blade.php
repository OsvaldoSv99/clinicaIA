<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; border-bottom: 2px solid #00bcd4; padding-bottom: 10px; margin-bottom: 20px; }
        .clinic-name { color: #4a90e2; font-size: 24px; font-weight: bold; }
        .content { margin-bottom: 20px; }
        .label { font-weight: bold; }
        .footer { font-size: 12px; text-align: center; color: #777; border-top: 1px solid #ddd; padding-top: 10px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="clinic-name">FISIODERMA</div>
            <p>Receta Médica</p>
        </div>

        <div class="content">
            <p><span class="label">Paciente:</span> {{ $medicalRecord->patient->name }}</p>
            <p><span class="label">Fecha:</span> {{ $medicalRecord->visit_date->format('d/m/Y') }}</p>
            <p><span class="label">Doctor:</span> {{ $medicalRecord->doctor->name }}</p>

            <hr>

            <h3>Diagnóstico</h3>
            <p>{{ $medicalRecord->diagnosis }}</p>

            <h3>Indicaciones</h3>
            <div style="background-color: #ffffcc; padding: 10px;">
                {!! nl2br(e($medicalRecord->indications)) !!}
            </div>

            @if($medicalRecord->next_appointment_date)
                <p><span class="label">Próxima Cita:</span> {{ $medicalRecord->next_appointment_date->format('d/m/Y') }}</p>
            @endif
        </div>

        <div class="footer">
            <p>Este correo contiene información confidencial de salud.</p>
            <p>Plaza Prisma: Consultorio 10. Prol 5 de mayo 742, Toluca de Lerdo, Edo. Méx.</p>
        </div>
    </div>
</body>
</html>
