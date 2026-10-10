<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Ver factura en el navegador (imprimir)
     */
    public function show(Sale $sale)
    {
        $pdf = $this->generatePdf($sale);
        $filename = $this->getFilename($sale);

        return $pdf->stream($filename);
    }

    /**
     * Descargar factura como PDF
     */
    public function download(Sale $sale)
    {
        $pdf = $this->generatePdf($sale);
        $filename = $this->getFilename($sale);

        return $pdf->download($filename);
    }

    /**
     * Generar el PDF (método privado reutilizable)
     */
    private function generatePdf(Sale $sale)
    {
        // Seguridad: solo el dueño o admin puede ver
        if ($sale->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'No autorizado para ver esta factura.');
        }

        // Cargar relaciones
        $sale->load(['client', 'user', 'products']);

        // Generar el PDF
        $pdf = Pdf::loadView('invoices.pdf', compact('sale'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }

    /**
     * Generar el nombre del archivo
     */
    private function getFilename(Sale $sale): string
    {
        return 'Factura-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) . '.pdf';
    }
}
