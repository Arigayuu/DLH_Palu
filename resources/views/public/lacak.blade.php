@extends('layouts.app')

@section('title', 'Lacak Laporan - DLH Kota Palu')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="text-center md:text-left space-y-2">
        <h1 class="text-3xl font-extrabold tracking-tight">Lacak Status Aduan Anda</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Masukkan nomor tiket rahasia aduan Anda untuk melihat status verifikasi dan tindak lanjut dari petugas lapangan.</p>
    </div>
    
    <livewire:public.lacak-laporan />
</div>
@endsection
