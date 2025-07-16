<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Mostrar la página de preguntas frecuentes.
     */
    public function index()
    {
        // Obtener FAQs activos ordenados desde la base de datos
        $faqs = Faq::active()->ordered()->get();

        // Agrupar FAQs por categoría
        $groupedFaqs = $faqs->groupBy('category');

        return view('faq.index', compact('groupedFaqs'));
    }
}
