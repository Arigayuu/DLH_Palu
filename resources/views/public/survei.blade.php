@extends('layouts.app')

@section('title', 'Survei IKM - DLH Kota Palu')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="text-center md:text-left space-y-2">
        <h1 class="text-3xl font-extrabold tracking-tight">Survei Indeks Kepuasan Masyarakat (IKM)</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Bantu kami meningkatkan kualitas pelayanan dengan mengisi survei kepuasan terhadap layanan pengelolaan pohon pelindung.</p>
    </div>
    
    <livewire:public.survei-ikm />
</div>
@endsection
