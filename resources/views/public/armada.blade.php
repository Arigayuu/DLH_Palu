@extends('layouts.app')

@section('title', 'Pelacakan Armada Sampah - DLH Kota Palu')

@section('content')
<div class="space-y-6">
    <div class="text-center md:text-left space-y-2">
        <h1 class="text-3xl font-extrabold tracking-tight">Pelacakan Armada Sampah Real-Time</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Pantau lokasi real-time armada truk sampah dan pickup Dinas Lingkungan Hidup Kota Palu yang sedang aktif beroperasi hari ini.</p>
    </div>

    <livewire:public.tracking-armada />
</div>
@endsection
