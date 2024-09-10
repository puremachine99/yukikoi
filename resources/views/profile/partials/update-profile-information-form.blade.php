<section>
    <header>
        <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
            {{ __("Update your account's profile information and email address.") }}
        </p> 
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="mb-4">
            <img id="profilePhotoPreview"
                src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('default-profile.png') }}"
                alt="Profile Photo" class="object-cover mb-4" style="height: 100px; width: auto;">
        </div>
        <div>
            <x-input-label for="profile_photo" :value="__('Profile Photo')" />
            <input id="profile_photo" name="profile_photo" type="file" class="mt-1 block w-full" accept="image/*"
                onchange="previewProfilePhoto(event)" />
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Tambahkan Field Baru di Sini -->
        <div>
            <x-input-label for="farm_name" :value="__('Farm Name')" />
            <x-text-input id="farm_name" name="farm_name" type="text" class="mt-1 block w-full" :value="old('farm_name', $user->farm_name)"
                required autocomplete="farm-name" />
            <x-input-error class="mt-2" :messages="$errors->get('farm_name')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)"
                autocomplete="address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)"
                autocomplete="city" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>
        <div>
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input id="nik" name="nik" type="text" maxlength="16" class="mt-1 block w-full" :value="old('nik', $user->nik)"
                required autocomplete="nik" />
            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
        </div>

        <div>
            <x-input-label for="ktp_photo" :value="__('KTP Photo')" />
            <input id="ktp_photo" name="ktp_photo" type="file" class="mt-1 block w-full" accept="image/*" />
            <x-input-error class="mt-2" :messages="$errors->get('ktp_photo')" />
        </div>

        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                :value="old('phone_number', $user->phone_number)" required autocomplete="phone-number" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Menjadi Seller')" />
            @if ($user->is_seller)
                <p class="text-green-500">Anda seorang seller, anda dapat membuat lelang, dan jual beli.</p>
                <button class="bg-gray-400 text-white py-2 px-4 rounded mt-2" disabled>Sudah Menjadi Seller</button>
            @else
                <button id="becomeSellerButton" type="button"
                    class="bg-blue-500 text-white py-2 px-4 rounded mt-2 hover:bg-blue-600">
                    Pengajuan
                </button>
            @endif
        </div>

        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Saved.') }}</p>
            @endif
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
</script>
