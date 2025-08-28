<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Skck;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SkckController extends Controller
{
    public function create()
    {
        $expiryMonths = Setting::getValue('skck_expiry_months', 6);

        return view('skck.create', compact('expiryMonths'));
    }

    public function show($id)
    {
        $skck = Skck::findOrFail($id);
        return view('skck.show', compact('skck'));
    }

    public function generateDocx($id)
    {
        $skck = Skck::findOrFail($id);

        $templatePath = storage_path('app/templates/skck_template.docx');
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);
        $defaultValue = '-';

        // Isi data ke template
        $phpWord->setValue('NAMA_LENGKAP', $skck->nama_lengkap ?? $defaultValue);
        $phpWord->setValue('NIK', $skck->nik ?? $defaultValue);
        $phpWord->setValue('KEWARGANEGARAAN', $skck->kewarganegaraan ?? $defaultValue);
        $phpWord->setValue('JENIS_KELAMIN', $skck->jenis_kelamin ?? $defaultValue);
        $phpWord->setValue('PEKERJAAN', $skck->pekerjaan ?? $defaultValue);
        $phpWord->setValue('AGAMA', $skck->agama ?? $defaultValue);
        $phpWord->setValue('ALAMAT', $skck->alamat ?? $defaultValue);
        $phpWord->setValue('PASSPOR', $skck->passpor ?? $defaultValue);
        $phpWord->setValue('SIDIK_JARI', $defaultValue);
        $phpWord->setValue('KEPERLUAN', $skck->keperluan ?? $defaultValue);
        $phpWord->setValue('TEMPAT_LAHIR', $skck->tempat_lahir ?? $defaultValue);
        $phpWord->setValue('TANGGAL_LAHIR', $skck->tanggal_lahir->format('j F Y') ?? $defaultValue);
        $phpWord->setValue('TANGGAL_MASUK', $skck->tanggal_masuk_formatted ?? $defaultValue);
        $phpWord->setValue('TANGGAL_SEKARANG', $skck->tanggal_dibuat->format('j F Y') ?? $defaultValue);
        $phpWord->setValue('MASA_BERLAKU', $skck->masa_berlaku->format('j F Y') ?? $defaultValue);

        $fileName = 'SKCK_' . $skck->nama_lengkap . '.docx';
        $tempFile = tempnam(sys_get_temp_dir(), $fileName);

        $phpWord->saveAs($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_lengkap' => 'required|string|max:100',
            'kewarganegaraan' => 'required|in:Indonesia,Asing',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan,',
            'tanggal_masuk' => 'required|date|before_or_equal:today',
            'alamat' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:50',
            'agama' => 'required|string',
            'jenis_pembayaran' => 'required|in:online,tunai,online_sudah_bayar',
            'agama' => 'required|string',
            'keperluan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        // Validasi khusus NIK/Passport
        if ($request->kewarganegaraan === 'Indonesia') {
            $rules['nik'] = 'required|digits:16|unique:skcks,nik';
        } else {
            $rules['passport'] = 'required|string|max:50|unique:skcks,passport';
        }

        $validated = $request->validate($rules);

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('skck/foto', 'public');
        }

        // Generate nomor SKCK
        $nomorSkck = $this->generateNomorSkck();

        $skck = Skck::create([
            'nomor_skck' => $nomorSkck,
            'nama_lengkap' => $request->nama_lengkap,
            'kewarganegaraan' => $request->kewarganegaraan,
            'nik' => $request->kewarganegaraan === 'Indonesia' ? $request->nik : null,
            'passport' => $request->kewarganegaraan === 'Asing' ? $request->passport : null,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_masuk' => $request->tanggal_masuk,
            'alamat' => $request->alamat,
            'agama' => $request->agama ?? 'Islam',
            'pekerjaan' => $request->pekerjaan,
            'keperluan' => $request->keperluan,
            'jenis_pembayaran' => $request->jenis_pembayaran ?? 'tunai',
            'petugas_id' => Auth::id(),
            'masa_berlaku' => $request->masa_berlaku,
            'foto_path' => $fotoPath,
            'tanggal_dibuat' => now(),
        ]);

        return redirect()->route('skck.show', $skck->id)
            ->with('success', 'SKCK berhasil dibuat dengan nomor: ' . $nomorSkck);
    }

    private function generateNomorSkck()
    {
        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        $count = Skck::whereYear('created_at', date('Y'))->count() + 1;

        return str_pad($count, 3, '0', STR_PAD_LEFT) . '/' . $bulanRomawi[date('n')] . '/' . date('Y');
    }


    public function list(Request $request)
    {
        $query = Skck::query();

        // Fitur pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_lengkap', 'like', "%$search%")
                ->orWhere('nik', 'like', "%$search%")
                ->orWhere('nomor_skck', 'like', "%$search%");
        }

        // Fitur filter tanggal
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_dibuat', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $skckList = $query->latest()->paginate(10);

        return view('skck.list', compact('skckList'));
    }
}
