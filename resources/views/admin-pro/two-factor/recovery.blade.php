@extends('layouts.admin')

@section('title', 'Codes de récupération 2FA')
@section('page-title', 'Codes de récupération')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('admin.two-factor.index') }}"
                class="inline-flex items-center text-sm text-slate-600 hover:text-slate-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour aux paramètres 2FA
            </a>
        </div>

        @if (isset($regenerated) && $regenerated)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-sm text-green-800 font-medium">
                        Nouveaux codes de récupération générés avec succès!
                    </p>
                </div>
            </div>
        @endif

        <!-- Warning Banner -->
        <div class="mb-6 bg-gradient-to-r from-amber-50 to-orange-50 border-l-4 border-amber-500 rounded-lg p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-amber-900 mb-2">⚠️ Important - Conservez ces codes en sécurité</h3>
                    <ul class="text-sm text-amber-800 space-y-1">
                        <li>• Chaque code ne peut être utilisé qu'<strong>une seule fois</strong></li>
                        <li>• Sauvegardez-les dans un endroit sûr (gestionnaire de mots de passe, coffre-fort, etc.)</li>
                        <li>• Utilisez-les uniquement si vous n'avez plus accès à votre application d'authentification</li>
                        <li>• Ne partagez jamais ces codes avec personne</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recovery Codes -->
        <div class="bg-white rounded-lg shadow-sm border border-slate-200">
            <div class="px-6 py-4 border-b border-slate-200 bg-slate-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Vos codes de récupération</h2>
                        <p class="text-sm text-slate-600 mt-1">{{ count($codes ?? []) }} codes disponibles</p>
                    </div>
                    <button onclick="printCodes()"
                        class="inline-flex items-center px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-sm font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Imprimer
                    </button>
                </div>
            </div>

            <div class="p-6" id="recovery-codes-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
                    @foreach ($codes ?? [] as $code)
                        <div
                            class="flex items-center gap-3 p-4 bg-slate-50 border border-slate-200 rounded-lg font-mono text-sm">
                            <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            <code class="flex-1 text-slate-900 font-semibold tracking-wider">{{ $code }}</code>
                            <button onclick="copyCode('{{ $code }}', this)"
                                class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                Copier
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                    <button onclick="downloadCodes()"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Télécharger (TXT)
                    </button>

                    <!-- Regenerate -->
                    <details class="relative">
                        <summary
                            class="inline-flex items-center px-4 py-2 bg-amber-100 text-amber-800 rounded-lg hover:bg-amber-200 transition font-medium cursor-pointer">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Régénérer les codes
                        </summary>

                        <div
                            class="absolute right-0 mt-2 w-96 bg-white rounded-lg shadow-xl border border-slate-200 p-4 z-10">
                            <h4 class="font-medium text-slate-900 mb-2">⚠️ Attention</h4>
                            <p class="text-sm text-slate-600 mb-4">
                                La régénération va <strong>invalider tous les codes actuels</strong>. Assurez-vous d'avoir
                                accès à votre application d'authentification.
                            </p>

                            <form action="{{ route('admin.two-factor.recovery.regenerate') }}" method="POST"
                                class="space-y-3">
                                @csrf
                                <input type="password" name="password" placeholder="Votre mot de passe" required
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-amber-500">
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition text-sm font-medium">
                                    Confirmer la régénération
                                </button>
                            </form>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyCode(code, button) {
            navigator.clipboard.writeText(code);
            const original = button.textContent;
            button.textContent = 'Copié!';
            button.classList.add('text-green-600');
            setTimeout(() => {
                button.textContent = original;
                button.classList.remove('text-green-600');
            }, 2000);
        }

        function downloadCodes() {
            const codes = @json($codes ?? []);
            const text = 'SAVE ME - Codes de récupération 2FA\n' +
                'Date: ' + new Date().toLocaleDateString('fr-FR') + '\n' +
                'Email: {{ auth()->user()->email }}\n\n' +
                'CODES:\n' +
                codes.join('\n') + '\n\n' +
                'IMPORTANT:\n' +
                '- Conservez ces codes en lieu sûr\n' +
                '- Chaque code ne peut être utilisé qu\'une seule fois\n' +
                '- Ne partagez jamais ces codes';

            const blob = new Blob([text], {
                type: 'text/plain'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'saveme-recovery-codes-' + Date.now() + '.txt';
            a.click();
            URL.revokeObjectURL(url);
        }

        function printCodes() {
            window.print();
        }
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #recovery-codes-content,
            #recovery-codes-content * {
                visibility: visible;
            }

            #recovery-codes-content {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endsection
