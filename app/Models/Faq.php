<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'question',
        'answer',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Scope para obtener solo FAQs activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope para ordenar por orden y fecha
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'asc');
    }

    /**
     * Scope para obtener FAQs por categoría
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
