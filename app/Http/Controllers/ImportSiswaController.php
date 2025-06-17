<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class ImportSiswaController extends Controller
{
    public function form()
    {
        return view('petugas.import-siswa');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()->back()->with('success', 'Data siswa berhasil diimpor.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Tangkap error validasi dari Excel
            $failures = $e->failures();
            
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            Log::error('Excel Import Validation Error:', $errors);
            return redirect()->back()->withErrors(['file' => 'Error pada data: ' . implode(' | ', $errors)]);
            
        } catch (\Exception $e) {
            // Tangkap semua error lainnya
            Log::error('Excel Import Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->withErrors(['file' => 'Terjadi kesalahan saat import: ' . $e->getMessage()]);
        }
    }
}