@extends('layouts.student')

@section('title', 'Ubah Password')
@section('page-title', 'Ubah Password')
@section('page-description', 'Ganti password akun Anda untuk keamanan yang lebih baik')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-navy to-navy-dark">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gold rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="text-white">
                        <h3 class="text-lg font-semibold">Ubah Password</h3>
                        <p class="text-blue-100 text-sm">Pastikan password baru Anda aman dan mudah diingat</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('student.profil.password.update') }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Saat Ini <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('current_password') border-red-500 @enderror"
                                placeholder="Masukkan password saat ini" required>
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('current_password')">
                                <svg id="current_password_icon" class="h-5 w-5 text-gray-400 hover:text-gray-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('password') border-red-500 @enderror"
                                placeholder="Masukkan password baru" required>
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password')">
                                <svg id="password_icon" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <!-- Password Strength Indicator -->
                        <div class="mt-2">
                            <div class="flex space-x-1">
                                <div id="strength-1" class="h-1 w-1/4 bg-gray-200 rounded transition-colors"></div>
                                <div id="strength-2" class="h-1 w-1/4 bg-gray-200 rounded transition-colors"></div>
                                <div id="strength-3" class="h-1 w-1/4 bg-gray-200 rounded transition-colors"></div>
                                <div id="strength-4" class="h-1 w-1/4 bg-gray-200 rounded transition-colors"></div>
                            </div>
                            <p id="strength-text" class="text-xs text-gray-500 mt-1">Kekuatan password akan ditampilkan di
                                sini</p>
                        </div>

                        <div class="mt-2 text-xs text-gray-500 space-y-1">
                            <p>Password yang kuat harus memiliki:</p>
                            <ul class="list-disc list-inside space-y-1 ml-2">
                                <li>Minimal 6 karakter</li>
                                <li>Kombinasi huruf besar dan kecil</li>
                                <li>Mengandung angka</li>
                                <li>Mengandung karakter khusus (!@#$%^&*)</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Konfirmasi Password Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent @error('password_confirmation') border-red-500 @enderror"
                                placeholder="Ulangi password baru" required>
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center"
                                onclick="togglePassword('password_confirmation')">
                                <svg id="password_confirmation_icon" class="h-5 w-5 text-gray-400 hover:text-gray-600"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <!-- Password Match Indicator -->
                        <div id="password-match" class="mt-2 text-xs hidden">
                            <div id="match-success" class="text-green-600 hidden">
                                ✓ Password cocok
                            </div>
                            <div id="match-error" class="text-red-600 hidden">
                                ✗ Password tidak cocok
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Tips -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <div>
                            <h4 class="font-medium text-blue-800 mb-2">Tips Keamanan Password</h4>
                            <div class="text-sm text-blue-700 space-y-1">
                                <p>• Jangan gunakan informasi pribadi seperti nama, tanggal lahir, atau NISN</p>
                                <p>• Hindari menggunakan password yang sama dengan akun lain</p>
                                <p>• Ganti password secara berkala untuk keamanan maksimal</p>
                                <p>• Jangan berikan password Anda kepada orang lain</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('student.profil.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn"
                        class="px-6 py-2 bg-navy text-white rounded-lg hover:bg-navy-dark transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function togglePassword(fieldId) {
                const passwordInput = document.getElementById(fieldId);
                const eyeIcon = document.getElementById(fieldId + '_icon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                    `;
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    `;
                }
            }

            function checkPasswordStrength(password) {
                let strength = 0;
                let strengthText = 'Lemah';
                let strengthColor = 'red';

                // Length check
                if (password.length >= 6) strength++;
                if (password.length >= 8) strength++;

                // Character variety checks
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                if (/\d/.test(password)) strength++;
                if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) strength++;

                // Update strength indicator
                const indicators = ['strength-1', 'strength-2', 'strength-3', 'strength-4'];
                indicators.forEach((id, index) => {
                    const element = document.getElementById(id);
                    if (index < strength) {
                        if (strength <= 2) {
                            element.className = element.className.replace('bg-gray-200', 'bg-red-400');
                        } else if (strength <= 3) {
                            element.className = element.className.replace('bg-gray-200', 'bg-yellow-400');
                        } else {
                            element.className = element.className.replace('bg-gray-200', 'bg-green-400');
                        }
                    } else {
                        element.className = element.className.replace(/bg-(red|yellow|green)-400/, 'bg-gray-200');
                    }
                });

                // Update strength text
                if (strength <= 2) {
                    strengthText = 'Lemah';
                    strengthColor = 'red';
                } else if (strength <= 3) {
                    strengthText = 'Sedang';
                    strengthColor = 'yellow';
                } else {
                    strengthText = 'Kuat';
                    strengthColor = 'green';
                }

                document.getElementById('strength-text').textContent = `Kekuatan password: ${strengthText}`;
                document.getElementById('strength-text').className = `text-xs text-${strengthColor}-600 mt-1`;

                return strength;
            }

            function checkPasswordMatch() {
                const password = document.getElementById('password').value;
                const confirmation = document.getElementById('password_confirmation').value;
                const matchDiv = document.getElementById('password-match');
                const matchSuccess = document.getElementById('match-success');
                const matchError = document.getElementById('match-error');

                if (confirmation.length === 0) {
                    matchDiv.classList.add('hidden');
                    return false;
                }

                matchDiv.classList.remove('hidden');

                if (password === confirmation) {
                    matchSuccess.classList.remove('hidden');
                    matchError.classList.add('hidden');
                    return true;
                } else {
                    matchSuccess.classList.add('hidden');
                    matchError.classList.remove('hidden');
                    return false;
                }
            }

            function updateSubmitButton() {
                const currentPassword = document.getElementById('current_password').value;
                const password = document.getElementById('password').value;
                const confirmation = document.getElementById('password_confirmation').value;
                const submitBtn = document.getElementById('submit-btn');

                const strength = checkPasswordStrength(password);
                const passwordsMatch = checkPasswordMatch();

                const isValid = currentPassword.length > 0 &&
                    password.length >= 6 &&
                    passwordsMatch &&
                    strength >= 2;

                submitBtn.disabled = !isValid;
            }

            // Add event listeners
            document.getElementById('current_password').addEventListener('input', updateSubmitButton);
            document.getElementById('password').addEventListener('input', updateSubmitButton);
            document.getElementById('password_confirmation').addEventListener('input', updateSubmitButton);

            // Auto-focus first field
            document.getElementById('current_password').focus();
        </script>
    @endpush

@endsection
