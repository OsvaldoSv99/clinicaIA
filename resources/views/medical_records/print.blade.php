<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receta Médica - {{ $medicalRecord->patient->name }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #00bcd4; /* Cyan color matching logo */
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .logo-container {
            width: 150px;
            text-align: center;
        }
        /* Placeholder for logo circle */
        .logo-circle {
            width: 80px;
            height: 80px;
            border: 2px solid #00bcd4;
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #00bcd4;
            font-weight: bold;
        }
        .clinic-name {
            font-size: 24px;
            font-weight: bold;
            color: #4a90e2; /* Blue color */
            text-transform: uppercase;
        }
        .meta-info {
            text-align: right;
            font-size: 14px;
        }
        .meta-row {
            margin-bottom: 5px;
        }
        .patient-info {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .info-item {
            display: flex;
        }
        .info-label {
            font-weight: bold;
            margin-right: 10px;
        }
        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .content-box {
            margin-bottom: 20px;
            min-height: 100px;
        }
        .diagnosis-box {
            border-bottom: 1px solid #333;
            padding-bottom: 5px;
            margin-bottom: 20px;
            display: flex;
        }
        .diagnosis-content {
            flex-grow: 1;
            font-weight: bold;
        }
        .indications-title {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
            font-size: 16px;
        }
        .indications-content {
            background-color: #ffffcc; /* Yellow highlight look */
            padding: 10px;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 3px solid #00bcd4;
            padding-top: 10px;
            font-size: 12px;
        }
        .footer-left {
            text-align: left;
        }
        .footer-right {
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 250px;
            margin: 0 auto 5px auto;
            padding-top: 5px;
        }
        .doctor-name {
            font-weight: bold;
            font-size: 14px;
        }
        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                padding: 0;
            }
            /* Ensure background colors print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo-container">
            <div class="logo-circle">LOGO</div>
            <div style="font-size: 12px; margin-top: 5px;">FISIODERMA</div>
        </div>
        <div class="clinic-name">FISIODERMA</div>
        <div class="meta-info">
            <div class="meta-row"><span class="info-label">FECHA:</span> {{ $medicalRecord->visit_date->format('d-m-Y') }}</div>
            <div class="meta-row"><span class="info-label">N° DE EXPEDIENTE:</span> FD-{{ str_pad($medicalRecord->patient->id, 5, '0', STR_PAD_LEFT) }}</div>
        </div>
    </div>

    <div class="patient-info">
        <div class="info-item" style="flex-grow: 1;">
            <span class="info-label">NOMBRE:</span> {{ $medicalRecord->patient->name }}
        </div>
        <div class="info-item" style="width: 100px;">
            <span class="info-label">EDAD:</span> {{ \Carbon\Carbon::parse($medicalRecord->patient->dob)->age }}
        </div>
        <div class="info-item" style="width: 150px;">
            <span class="info-label">SEXO:</span> - 
        </div>
    </div>

    <div class="diagnosis-box">
        <span class="section-title" style="min-width: 250px;">DIAGNÓSTICO FISIOTERAPEUTICO</span>
        <span class="diagnosis-content">{{ $medicalRecord->diagnosis }}</span>
    </div>

    <div class="indications-title">INDICACIONES</div>
    
    <div class="content-box">
        <div class="indications-content">
            {{ $medicalRecord->indications }}
        </div>
    </div>

    <div class="footer">
        <div class="footer-left">
            @if($medicalRecord->next_appointment_date)
                <div style="font-weight: bold; font-size: 14px;">{{ $medicalRecord->next_appointment_date->format('d-m-Y') }}</div>
                <div style="border-top: 1px solid #333; width: 200px; padding-top: 5px;">PRÓXIMA CITA</div>
            @endif
        </div>
        <div class="footer-right">
            <div style="height: 40px;">
                @if($medicalRecord->signature_path)
                    <img src="{{ public_path('storage/' . $medicalRecord->signature_path) }}" alt="Firma Doctor" style="max-height: 60px; max-width: 200px;">
                @endif
            </div> <!-- Space for signature -->
            <div class="signature-line"></div>
            <div class="doctor-name">{{ $medicalRecord->doctor->name }}</div>
            <div>Ced. Prof. KJK34JN4</div> <!-- Placeholder or add to Doctor model -->
            <div style="font-size: 10px; margin-top: 5px;">NOMBRE Y FIRMA DEL FISIOTERAPEUTA</div>
        </div>
    </div>
    
    <div style="background-color: #4a90e2; color: white; padding: 5px; font-size: 10px; text-align: center; margin-top: 20px;">
        Plaza Prisma: Consultorio 10. Prol 5 de mayo 742, Col. Comisión Federal de Electricidad, Del. San Sebastián, Toluca de Lerdo, Estado de México, C.P: 50150<br>
        Tel: 722 516 5535 Correo Electrónico: fisiodermatoluca@gmail.com
    </div>

    <button class="print-btn" onclick="window.print()">Imprimir</button>

</body>
</html>
