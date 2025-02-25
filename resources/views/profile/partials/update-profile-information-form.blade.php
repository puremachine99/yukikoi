<section>
    <header>
        <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
            Informasi Profil
        </h2>
        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
            Perbarui informasi akun Anda dan alamat email.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf
        @method('patch')

        <!-- Foto Profil -->
        <div class="md:col-span-2 flex items-center gap-4">
            <img id="profilePhotoPreview"
                src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('default-profile.png') }}"
                alt="Foto Profil" class="object-cover rounded-full" style="height: 100px; width: 100px;">
            <div>
                <label for="profile_photo" class="block text-sm font-medium">Logo Farm</label>
                <input id="profile_photo" name="profile_photo" type="file" class="mt-1 block" accept="image/*"
                    onchange="previewProfilePhoto(event)" />
                <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
            </div>
        </div>

        <!-- Informasi Umum -->
        <div>
            <x-input-label for="name" :value="'Nama'" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="farm_name" :value="'Nama Farm'" />
            <x-text-input id="farm_name" name="farm_name" type="text" class="mt-1 block w-full" :value="old('farm_name', $user->farm_name)"
                required />
            <x-input-error class="mt-2" :messages="$errors->get('farm_name')" />
        </div>

        <div>
            <x-input-label for="phone_number" :value="'Nomor Telepon'" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                :value="old('phone_number', $user->phone_number)" required />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <x-input-label for="city" :value="'Kota'" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="address" :value="'Alamat'" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="nik" :value="'NIK'" />
            <x-text-input id="nik" name="nik" type="text" maxlength="16" class="mt-1 block w-full"
                :value="old('nik', $user->nik)" required />
            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
        </div>

        <div>
            <x-input-label for="ktp_photo" :value="'Foto KTP'" />
            <input id="ktp_photo" name="ktp_photo" type="file" class="mt-1 block w-full" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('ktp_photo')" />
        </div>

        <div class="md:col-span-2">
            <x-input-label for="bio" :value="'Bio'" />
            <x-textarea id="bio" name="bio" rows="3" maxlength="160" class="mt-1 block w-full"
                oninput="updateCharacterCount()">{{ old('bio', $user->bio) }}</x-textarea>
            <div class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">
                <span id="charCount">160</span> karakter tersisa.
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div class="md:col-span-2">
            <x-primary-button>Simpan</x-primary-button>
        </div>
    </form>
</section>

<script>
    document.getElementById('becomeSellerButton').addEventListener('click', function() {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('profile.becomeSeller') }}";
        form.innerHTML = `@csrf`;
        document.body.appendChild(form);
        form.submit();
    });

    function previewProfilePhoto(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('profilePhotoPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Inisialisasi jumlah karakter saat halaman dimuat
        updateCharacterCount();
    });

    function updateCharacterCount() {
        const bio = document.getElementById('bio');
        const charCount = document.getElementById('charCount');
        const maxLength = bio.getAttribute('maxlength');
        const currentLength = bio.value.length;
        charCount.textContent = maxLength - currentLength;
    }
</script>
