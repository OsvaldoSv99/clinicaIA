<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
    public function index(Patient $patient)
    {
        $medicalRecords = $patient->medicalRecords()->with('doctor')->latest('visit_date')->get();
        return view('patients.history', compact('patient', 'medicalRecords'));
    }

    public function create(Patient $patient)
    {
        $doctors = Doctor::all();
        return view('medical_records.create', compact('patient', 'doctors'));
    }

    public function store(Request $request, Patient $patient)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'diagnosis' => 'required|string',
            'indications' => 'required|string',
            'next_appointment_date' => 'nullable|date',
            'signature' => 'nullable|string',
        ]);

        $signaturePath = null;
        if ($request->signature) {
            $image = $request->signature;  // your base64 encoded
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'signature_' . time() . '.png';
            \Illuminate\Support\Facades\Storage::disk('public')->put('signatures/' . $imageName, base64_decode($image));
            $signaturePath = 'signatures/' . $imageName;
        }

        $medicalRecord = new MedicalRecord([
            'doctor_id' => $request->doctor_id,
            'visit_date' => now(),
            'diagnosis' => $request->diagnosis,
            'indications' => $request->indications,
            'next_appointment_date' => $request->next_appointment_date,
            'signature_path' => $signaturePath,
        ]);

        $patient->medicalRecords()->save($medicalRecord);

        return redirect()->route('patients.history', $patient)->with('success', 'Consulta registrada correctamente.');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return view('medical_records.print', compact('medicalRecord'));
    }

    public function email(MedicalRecord $medicalRecord)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('medical_records.print', compact('medicalRecord'));
        
        \Illuminate\Support\Facades\Mail::to($medicalRecord->patient->email)
            ->send(new \App\Mail\MedicalRecordMail($medicalRecord, $pdf->output()));
            
        return back()->with('success', 'Receta enviada por correo exitosamente.');
    }
}
