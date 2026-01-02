@extends('layouts.app')

@section('title', 'DSAR')
@section('active_key', 'dsar')

@section('page_header')
<div class="flex justify-between items-center mb-4">
    <div>
        <h2 class="text-xl font-bold">Solicitudes DSAR</h2>
        <p class="text-sm text-gray-500">Gestión de derechos del titular</p>
    </div>

    <a href="{{ route('dsar.create') }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded flex items-center gap-2">
        <span class="text-lg font-bold">+</span> Nuevo
    </a>
</div>
@endsection

@section('content')

<div class="bg-white border rounded divide-y">

@forelse($dsars as $d)
    @php
        $daysLeft = \Carbon\Carbon::now()->diffInDays($d->due_at, false);
    @endphp

    <div class="p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

        <div>
            <h3 class="font-semibold">
                {{ $d->subject->full_name ?? 'Sin titular' }}
                – {{ $d->status_label }} {{-- Accessor para mostrar estado en español --}}
                @if($d->evidences->count() > 0)
                    <span class="ml-2 text-blue-600 text-sm font-medium">
                        📎 {{ $d->evidences->count() }} evidencia(s)
                    </span>
                @endif
            </h3>
            <p class="text-sm text-gray-500">
                Canal: {{ $d->channel }} |
                Vence: {{ $d->due_at->format('Y-m-d') }}
            </p>

            @if($daysLeft < 0)
                <span class="text-red-600 text-sm font-semibold">Vencido</span>
            @elseif($daysLeft <= 5)
                <span class="text-yellow-600 text-sm font-semibold">Próximo a vencer</span>
            @endif
        </div>

        <div class="flex gap-2">
            <!-- Botón Editar -->
            <a href="{{ route('dsar.edit', $d) }}"
               class="w-9 h-9 flex items-center justify-center rounded bg-yellow-500 hover:bg-yellow-600 text-white text-lg font-bold">
               ✏️
            </a>

            <!-- Botón Agregar Evidencia -->
            <a href="{{ route('dsar.edit', $d) }}#evidences"
               class="w-9 h-9 flex items-center justify-center rounded bg-blue-500 hover:bg-blue-600 text-white text-lg font-bold">
               📎
            </a>
        </div>
    </div>

@empty
    <p class="p-4 text-gray-500 text-center">
        No existen solicitudes DSAR registradas
    </p>
@endforelse

</div>
@endsection
