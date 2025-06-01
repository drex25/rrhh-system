@extends('layouts.admin')

@section('content')
<!-- Fondo opaco -->
<div class="fixed inset-0 bg-gray-900 bg-opacity-80 flex items-center justify-center z-50 min-h-screen">
    <!-- Modal -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl p-12 animate-fade-in-up relative border border-blue-100 dark:border-gray-700">
        <div class="flex flex-col items-center mb-8">
            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-full mb-4">
                <svg class="w-12 h-12 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.104 0 2-.896 2-2V7a2 2 0 10-4 0v2c0 1.104.896 2 2 2zm0 0v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-blue-700 dark:text-white mb-2 text-center tracking-tight">Cambio de Contraseña Requerido</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-2 text-center max-w-xl">
                Por seguridad, debes cambiar tu contraseña antes de continuar. Elige una contraseña segura y fácil de recordar.
            </p>
        </div>
        <form class="space-y-8" action="{{ route('password.change') }}" method="POST">
            @csrf
            @if($errors->any())
                <div class="rounded-lg bg-red-50 dark:bg-red-900/50 p-4 mb-2">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-base font-semibold text-red-800 dark:text-red-200">
                                Se encontraron los siguientes errores:
                            </h3>
                            <div class="mt-2 text-base text-red-700 dark:text-red-300">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="current_password" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Contraseña Actual</label>
                    <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                        class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow focus:border-blue-500 focus:ring-blue-500 px-5 py-3 text-lg transition">
                </div>
                <div>
                    <label for="password" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Nueva Contraseña</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                        class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow focus:border-blue-500 focus:ring-blue-500 px-5 py-3 text-lg transition">
                </div>
                <div>
                    <label for="password_confirmation" class="block text-base font-medium text-gray-700 dark:text-gray-300 mb-2">Confirmar Nueva Contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                        class="block w-full rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow focus:border-blue-500 focus:ring-blue-500 px-5 py-3 text-lg transition">
                </div>
            </div>
            <div>
                <button type="submit"
                    class="w-full flex justify-center py-4 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white text-lg font-bold shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                    Cambiar Contraseña
                </button>
            </div>
        </form>
    </div>
</div>
<style>
@keyframes fade-in-up {
    0% { opacity: 0; transform: translateY(40px); }
    100% { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-up {
    animation: fade-in-up 0.4s cubic-bezier(0.4,0,0.2,1);
}
</style>
@endsection 