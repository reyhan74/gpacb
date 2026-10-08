<?php

namespace App\Services;

use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class KtaService
{
    /**
     * Generate KTA Digital persis format KTA resmi GPA SMK CB Pare
     */
    public static function generatePdf(Member $member)
    {
        $logoGpa = public_path('assets/logo-gpa.jpg');
        $logoGpaBase64 = file_exists($logoGpa)
            ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoGpa))
            : null;

        $photoBase64 = null;
        if ($member->foto && file_exists(storage_path('app/public/' . $member->foto))) {
            $photoPath = storage_path('app/public/' . $member->foto);
            $mime = mime_content_type($photoPath);
            $photoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($photoPath));
        }

        $html = view('kta.template', [
            'member' => $member,
            'logoGpaBase64' => $logoGpaBase64,
            'photoBase64' => $photoBase64,
        ])->render();

        $pdf = Pdf::loadHTML($html);
        // Ukuran kartu ID standar CR80: 85.6mm x 53.98mm → dalam points (1mm = 2.8346pt)
        // 85.6mm = 242.64pt, 53.98mm = 152.99pt
        $pdf->setPaper([0, 0, 242.64, 152.99], 'landscape');

        return $pdf;
    }
}
