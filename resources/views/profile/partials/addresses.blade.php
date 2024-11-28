<section>
    <header>
        <h2 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">
            {{ __('Kelola Alamat Penerima') }}
        </h2>
        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Tambahkan, ubah, atau hapus alamat penerima untuk mempermudah pengiriman.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        <!-- Form untuk Tambah/Edit -->
        <form id="address-form" method="POST" action="{{ route('profile.addresses.store') }}"
            class="{{ $addresses->count() >= 3 ? 'hidden' : '' }}">
            @csrf
            <input type="hidden" id="form-method" name="_method" value="POST">
            <input type="hidden" id="address-id" name="address_id" value="">

            <div>
                <x-input-label for="recipient_name" :value="__('Atas Nama')" />
                <x-text-input id="recipient_name" name="recipient_name" type="text" class="mt-1 block w-full"
                    required />
            </div>

            <div>
                <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
                <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" required />
            </div>

            <div>
                <x-input-label for="full_address" :value="__('Alamat Lengkap')" />
                <x-textarea id="full_address" name="full_address" rows="3" class="mt-1 block w-full"
                    required></x-textarea>
            </div>

            <div>
                <x-input-label for="city" :value="__('Kota')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" required />
            </div>

            <div>
                <x-input-label for="district" :value="__('Kecamatan')" />
                <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" required />
            </div>

            <div>
                <x-input-label for="type" :value="__('Tandai Alamat Ini Sebagai')" />
                <x-select id="type" name="type" class="mt-1 block w-full" required>
                    <option value="lain-lain">{{ __('Lain-lain') }}</option>
                    <option value="rumah">{{ __('Rumah') }}</option>
                    <option value="kantor">{{ __('Kantor') }}</option>
                </x-select>
            </div>

            <div class="mt-4">
                <input id="is_default" name="is_default" type="checkbox" value="1">
                <x-input-label for="is_default" :value="__('Jadikan Default')" />
            </div>

            <div class="mt-4">
                <x-primary-button id="form-submit">{{ __('Tambah') }}</x-primary-button>
            </div>
        </form>

        <!-- List of Addresses -->
        @if ($addresses->isNotEmpty())
            <div class="space-y-4">
                @foreach ($addresses as $address)
                    <div class="bg-white dark:bg-zinc-900 p-4 rounded-lg shadow flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-zinc-800 dark:text-zinc-100">{{ $address->recipient_name }}
                            </h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $address->phone_number }}</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $address->full_address }}</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $address->city }},
                                {{ $address->district }}</p>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ ucfirst($address->type) }}</p>

                            @if ($address->is_default)
                                <span
                                    class="mt-2 inline-block px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-md">
                                    Alamat Utama
                                </span>
                            @else
                                <form method="post"
                                    action="{{ route('profile.addresses.setDefault', $address->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="mt-2 inline-block px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-md">
                                        Jadikan Alamat Utama
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="flex flex-col space-y-2">


                            <!-- Tombol Edit -->
                            <x-secondary-button type="button" class="edit-button x-secondary-button" data-id="{{ $address->id }}"
                                data-name="{{ $address->recipient_name }}" data-phone="{{ $address->phone_number }}"
                                data-address="{{ $address->full_address }}" data-city="{{ $address->city }}"
                                data-district="{{ $address->district }}" data-type="{{ $address->type }}"
                                data-default="{{ $address->is_default }}">
                                {{ __('Edit') }}
                            </x-secondary-button>

                            <!-- Tombol Delete -->
                            <form method="post" action="{{ route('profile.addresses.destroy', $address->id) }}">
                                @csrf
                                @method('DELETE')
                                <x-danger-button>{{ __('Delete') }}</x-danger-button>
                            </form>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('address-form');
            const formMethod = document.getElementById('form-method');
            const addressIdInput = document.getElementById('address-id');
            const formSubmitButton = document.getElementById('form-submit');

            // Set fields
            const recipientNameInput = document.getElementById('recipient_name');
            const phoneNumberInput = document.getElementById('phone_number');
            const fullAddressInput = document.getElementById('full_address');
            const cityInput = document.getElementById('city');
            const districtInput = document.getElementById('district');
            const typeInput = document.getElementById('type');
            const isDefaultCheckbox = document.getElementById('is_default');

            // Handle edit button click
            document.querySelectorAll('.edit-button').forEach((button) => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    form.action = `/profile/addresses/${id}`; // Ubah action URL ke update
                    formMethod.value = 'PUT'; // Ganti method jadi PUT
                    addressIdInput.value = id;

                    recipientNameInput.value = button.dataset.name;
                    phoneNumberInput.value = button.dataset.phone;
                    fullAddressInput.value = button.dataset.address;
                    cityInput.value = button.dataset.city;
                    districtInput.value = button.dataset.district;
                    typeInput.value = button.dataset.type;
                    isDefaultCheckbox.checked = button.dataset.default === '1';

                    formSubmitButton.textContent = 'Update';
                    form.classList.remove('hidden');
                });
            });
        });
    </script>
</section>
