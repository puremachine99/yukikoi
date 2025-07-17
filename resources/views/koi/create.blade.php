<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <a href="{{ route('koi.index', ['auction_code' => $auction_code]) }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-blue-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:from-indigo-700 hover:to-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 shadow-md">
                <i class="fas fa-arrow-left mr-2"></i> List Koi
            </a>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Koi Lelang #') . $auction_code }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl transition-all duration-300">
                <div class="container mx-auto px-4">
                    <form action="{{ route('koi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="auction_code" value="{{ $auction_code }}">

                        <!-- Wrapper untuk form koi dinamis -->
                        <div id="koiFormWrapper" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Form Koi pertama -->
                            <div class="koi-form p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-xl font-bold text-indigo-600 dark:text-indigo-400">Koi A</h3>
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold rounded-full">New</span>
                                </div>
                                
                                <!-- Input Judul Koi -->
                                <div class="mb-5">
                                    <x-input-label for="judul_koi" :value="__('Judul Koi')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input name="judul[]" placeholder="Masukkan judul untuk koi"
                                        class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200" />
                                </div>

                                <input type="hidden" name="kode_ikan[]" value="{{ $newKoiCode }}">
                                <!-- Jenis Koi -->
                                <div class="mb-5">
                                    <x-input-label for="jenis_koi" :value="__('Jenis Koi')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-dropdown-jenis-koi name="jenis_koi[]" class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200"></x-dropdown-jenis-koi>
                                </div>

                                <!-- Ukuran -->
                                <div class="mb-5">
                                    <x-input-label for="ukuran" :value="__('Ukuran (cm)')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-number-input name="ukuran[]" class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200" required />
                                </div>

                                <!-- Gender -->
                                <div class="mb-5">
                                    <x-input-label :value="__('Gender')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="flex flex-wrap gap-3 mt-2">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="gender[0]" value="Male"
                                                class="form-radio h-5 w-5 text-indigo-600 transition duration-150 ease-in-out focus:ring-2 focus:ring-indigo-300">
                                            <span class="ml-2 text-gray-700 dark:text-gray-300">Male</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="gender[0]" value="Female"
                                                class="form-radio h-5 w-5 text-indigo-600 transition duration-150 ease-in-out focus:ring-2 focus:ring-indigo-300">
                                            <span class="ml-2 text-gray-700 dark:text-gray-300">Female</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name="gender[0]" value="Unchecked" checked
                                                class="form-radio h-5 w-5 text-indigo-600 transition duration-150 ease-in-out focus:ring-2 focus:ring-indigo-300">
                                            <span class="ml-2 text-gray-700 dark:text-gray-300">Unchecked</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- Open Bid -->
                                <div class="mb-5">
                                    <x-input-label for="open_bid" :value="__('Open Bid (dalam ribuan)')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                                        <x-number-input name="open_bid[]" class="block w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200"
                                            placeholder="500 untuk Rp500.000" required />
                                    </div>
                                </div>

                                <!-- Kelipatan Bid -->
                                <div class="mb-5">
                                    <x-input-label for="kelipatan_bid" :value="__('Kelipatan Bid (dalam ribuan)')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                                        <x-number-input name="kelipatan_bid[]" class="block w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200"
                                            placeholder="50 untuk Rp50.000" required />
                                    </div>
                                </div>

                                <!-- Buy It Now -->
                                <div class="mb-5">
                                    <x-input-label for="buy_it_now" :value="__('Buy It Now (dalam ribuan)')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400">Rp</span>
                                        <x-number-input name="buy_it_now[]" class="block w-full pl-10 pr-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200"
                                            placeholder="1000 untuk Rp1.000.000" />
                                    </div>
                                </div>

                                <!-- Input Keterangan -->
                                <div class="mb-5">
                                    <x-input-label for="keterangan" :value="__('Keterangan')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <textarea name="keterangan[]" rows="3" placeholder="Deskripsi tentang koi"
                                        class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200"></textarea>
                                </div>

                                <!-- Input Breeder -->
                                <div class="mb-5">
                                    <x-input-label for="breeder" :value="__('Breeder')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <x-text-input name="breeder[]" placeholder="Nama Breeder Koi"
                                        class="block w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-indigo-300 focus:border-indigo-500 transition-all duration-200" />
                                </div>

                                <!-- Upload Video -->
                                <div class="mb-5">
                                    <x-input-label for="video_koi" :value="__('Video Koi (Max 1)')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="flex items-center justify-center w-full">
                                        <label for="video-koi-0" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="fas fa-video mb-2 text-gray-400 dark:text-gray-300"></i>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">MP4, MOV, AVI (MAX. 50MB)</p>
                                            </div>
                                            <x-file-input id="video-koi-0" name="video_koi[0]" class="hidden video-koi" accept="video/*" />
                                        </label>
                                    </div>
                                    <!-- Preview video -->
                                    <div class="preview-video mt-2 flex justify-center"></div>
                                </div>

                                <!-- Upload Gambar -->
                                <div class="mb-5">
                                    <x-input-label for="gambar_koi" :value="__('Gambar Koi')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="flex items-center justify-center w-full">
                                        <label for="gambar-koi-0" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="fas fa-images mb-2 text-gray-400 dark:text-gray-300"></i>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">JPG, PNG (MAX. 10MB each)</p>
                                            </div>
                                            <x-file-input id="gambar-koi-0" name="gambar_koi[0][]" class="hidden gambar-koi" accept="image/*" multiple />
                                        </label>
                                    </div>
                                    <!-- Preview gambar -->
                                    <div class="preview-gambar mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
                                </div>

                                <!-- Upload Sertifikat -->
                                <div class="mb-5">
                                    <x-input-label for="sertifikat_koi" :value="__('Sertifikat (Jika Ada)')" class="mb-1 text-sm font-medium text-gray-700 dark:text-gray-300" />
                                    <div class="flex items-center justify-center w-full">
                                        <label for="sertifikat-koi-0" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-400 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-all duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="fas fa-certificate mb-2 text-gray-400 dark:text-gray-300"></i>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">JPG, PNG, PDF (MAX. 10MB each)</p>
                                            </div>
                                            <x-file-input id="sertifikat-koi-0" name="sertifikat_koi[0][]" class="hidden sertifikat-koi" accept="image/*" multiple />
                                        </label>
                                    </div>
                                    <!-- Preview sertifikat -->
                                    <div class="preview-sertifikat mt-3 grid grid-cols-2 sm:grid-cols-3 gap-3"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Tambah Koi -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-8">
                            <x-secondary-button type="button" id="addKoiButton" class="flex items-center justify-center gap-2 hover:bg-gray-200 dark:hover:bg-gray-700 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-plus"></i>
                                <span>{{ __('Tambah Koi') }}</span>
                            </x-secondary-button>
                            <x-primary-button type="submit" class="flex items-center justify-center gap-2 bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-paper-plane"></i>
                                <span>{{ __('Submit') }}</span>
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fungsi untuk menghitung kode urutan (A-Z, AA-ZZ, dst.)
        function getKoiCode(index) {
            let code = '';
            while (index >= 0) {
                code = String.fromCharCode(index % 26 + 65) + code;
                index = Math.floor(index / 26) - 1;
            }
            return code;
        }

        // Fungsi untuk menampilkan preview gambar atau sertifikat
        function previewFiles(input, previewElement) {
            previewElement.innerHTML = ''; // Kosongkan preview sebelumnya
            const files = input.files;
            
            if (files && files.length > 0) {
                // Add a counter display
                const counter = document.createElement('div');
                counter.className = 'text-sm text-gray-500 dark:text-gray-400 mb-2';
                counter.textContent = `${files.length} file(s) selected`;
                previewElement.appendChild(counter);
                
                // Limit to 6 previews for better mobile display
                const maxPreviews = 6;
                const filesToShow = Array.from(files).slice(0, maxPreviews);
                
                filesToShow.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'relative group';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-24 object-cover rounded-lg border border-gray-200 dark:border-gray-600 group-hover:opacity-75 transition-opacity duration-200';
                        img.alt = 'Preview';
                        
                        // Add a hover overlay with file name
                        const overlay = document.createElement('div');
                        overlay.className = 'absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg';
                        
                        const fileName = document.createElement('p');
                        fileName.className = 'text-white text-xs px-2 text-center truncate w-full';
                        fileName.textContent = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;
                        
                        overlay.appendChild(fileName);
                        previewItem.appendChild(img);
                        previewItem.appendChild(overlay);
                        
                        previewElement.appendChild(previewItem);
                    };
                    reader.readAsDataURL(file);
                });
                
                if (files.length > maxPreviews) {
                    const moreText = document.createElement('div');
                    moreText.className = 'text-xs text-gray-500 dark:text-gray-400 mt-2';
                    moreText.textContent = `+${files.length - maxPreviews} more`;
                    previewElement.appendChild(moreText);
                }
            } else {
                const emptyState = document.createElement('div');
                emptyState.className = 'text-center py-4 text-gray-400 dark:text-gray-500';
                emptyState.innerHTML = '<i class="fas fa-image fa-2x mb-2"></i><p>No files selected</p>';
                previewElement.appendChild(emptyState);
            }
        }

        // Fungsi untuk menampilkan preview video
        function previewVideo(input, previewElement) {
            previewElement.innerHTML = ''; // Kosongkan preview sebelumnya
            const file = input.files[0]; // Ambil file pertama (hanya 1 video)
            
            if (file) {
                const fileInfo = document.createElement('div');
                fileInfo.className = 'text-sm text-gray-500 dark:text-gray-400 mb-2';
                fileInfo.textContent = `${file.name} (${(file.size / (1024 * 1024)).toFixed(2)}MB)`;
                previewElement.appendChild(fileInfo);
                
                const videoContainer = document.createElement('div');
                videoContainer.className = 'relative';
                
                const video = document.createElement('video');
                video.src = URL.createObjectURL(file);
                video.className = 'w-full h-48 object-cover rounded-lg border border-gray-200 dark:border-gray-600';
                video.controls = true;
                
                const playButton = document.createElement('div');
                playButton.className = 'absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200';
                playButton.innerHTML = '<div class="bg-black bg-opacity-50 rounded-full p-4"><i class="fas fa-play text-white text-xl"></i></div>';
                
                videoContainer.appendChild(video);
                videoContainer.appendChild(playButton);
                previewElement.appendChild(videoContainer);
            } else {
                const emptyState = document.createElement('div');
                emptyState.className = 'text-center py-4 text-gray-400 dark:text-gray-500';
                emptyState.innerHTML = '<i class="fas fa-video fa-2x mb-2"></i><p>No video selected</p>';
                previewElement.appendChild(emptyState);
            }
        }

        // Animation for adding new koi form
        function animateAddForm(newForm) {
            newForm.style.opacity = '0';
            newForm.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                newForm.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                newForm.style.opacity = '1';
                newForm.style.transform = 'translateY(0)';
                
                setTimeout(() => {
                    newForm.style.transition = '';
                }, 300);
            }, 10);
        }

        document.getElementById('addKoiButton').addEventListener('click', function() {
            let wrapper = document.getElementById('koiFormWrapper');
            let newKoiForm = wrapper.children[0].cloneNode(true); // Clone form pertama
            let totalForms = wrapper.children.length;
            
            // Update heading and remove "New" badge
            const heading = newKoiForm.querySelector('h3');
            heading.textContent = `Koi ${getKoiCode(totalForms)}`;
            heading.className = 'text-xl font-bold text-indigo-600 dark:text-indigo-400';
            newKoiForm.querySelector('span').remove();
            
            // Update all "name" attributes with new index
            let inputs = newKoiForm.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                let name = input.getAttribute('name');
                if (name && name.includes('[0]')) {
                    input.setAttribute('name', name.replace('[0]', `[${totalForms}]`));
                }
                // Reset values for the new form
                if (input.type !== 'radio' && input.type !== 'file' && input.type !== 'hidden') {
                    input.value = '';
                } else if (input.type === 'radio') {
                    input.checked = input.value === 'Unchecked';
                }
            });

            // Reset file inputs and previews
            newKoiForm.querySelector('.gambar-koi').value = '';
            newKoiForm.querySelector('.sertifikat-koi').value = '';
            newKoiForm.querySelector('.video-koi').value = '';
            newKoiForm.querySelector('.preview-gambar').innerHTML = '';
            newKoiForm.querySelector('.preview-sertifikat').innerHTML = '';
            newKoiForm.querySelector('.preview-video').innerHTML = '';
            
            // Set kode ikan (hidden input) using getKoiCode()
            newKoiForm.querySelector('input[name="kode_ikan[]"]').value = getKoiCode(totalForms);
            
            // Update file input IDs
            newKoiForm.querySelector('.gambar-koi').id = `gambar-koi-${totalForms}`;
            newKoiForm.querySelector('label[for="gambar-koi-0"]').htmlFor = `gambar-koi-${totalForms}`;
            newKoiForm.querySelector('.sertifikat-koi').id = `sertifikat-koi-${totalForms}`;
            newKoiForm.querySelector('label[for="sertifikat-koi-0"]').htmlFor = `sertifikat-koi-${totalForms}`;
            newKoiForm.querySelector('.video-koi').id = `video-koi-${totalForms}`;
            newKoiForm.querySelector('label[for="video-koi-0"]').htmlFor = `video-koi-${totalForms}`;
            
            wrapper.appendChild(newKoiForm);
            animateAddForm(newKoiForm);
            
            // Scroll to the new form with smooth animation
            setTimeout(() => {
                newKoiForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }, 350);

            // Add event listeners for the new form
            newKoiForm.querySelector('.gambar-koi').addEventListener('change', function() {
                previewFiles(this, newKoiForm.querySelector('.preview-gambar'));
            });

            newKoiForm.querySelector('.sertifikat-koi').addEventListener('change', function() {
                previewFiles(this, newKoiForm.querySelector('.preview-sertifikat'));
            });

            newKoiForm.querySelector('.video-koi').addEventListener('change', function() {
                previewVideo(this, newKoiForm.querySelector('.preview-video'));
            });
            
            // Add a remove button for the new form (except the first one)
            if (totalForms > 0) {
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'mt-4 w-full py-2 px-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 rounded-lg font-medium hover:bg-red-200 dark:hover:bg-red-800 transition-colors duration-200 flex items-center justify-center gap-2';
                removeBtn.innerHTML = '<i class="fas fa-trash"></i> Remove Koi';
                removeBtn.addEventListener('click', function() {
                    // Animate removal
                    newKoiForm.style.transition = 'opacity 0.3s ease, transform 0.3s ease, margin 0.3s ease';
                    newKoiForm.style.opacity = '0';
                    newKoiForm.style.transform = 'translateY(-20px)';
                    newKoiForm.style.marginTop = '-20px';
                    
                    setTimeout(() => {
                        newKoiForm.remove();
                        // Update headings of remaining forms
                        const forms = wrapper.querySelectorAll('.koi-form');
                        forms.forEach((form, index) => {
                            const heading = form.querySelector('h3');
                            if (heading) {
                                heading.textContent = `Koi ${getKoiCode(index)}`;
                            }
                        });
                    }, 300);
                });
                newKoiForm.appendChild(removeBtn);
            }
        });

        // Initial preview listeners for the first form
        document.querySelector('.gambar-koi').addEventListener('change', function() {
            previewFiles(this, document.querySelector('.preview-gambar'));
        });

        document.querySelector('.sertifikat-koi').addEventListener('change', function() {
            previewFiles(this, document.querySelector('.preview-sertifikat'));
        });

        document.querySelector('.video-koi').addEventListener('change', function() {
            previewVideo(this, document.querySelector('.preview-video'));
        });
        
        // Drag and drop functionality for file inputs
        function setupDragAndDrop(inputId, labelClass) {
            const input = document.getElementById(inputId);
            const label = document.querySelector(`label[for="${inputId}"]`);
            
            if (!input || !label) return;
            
            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                label.addEventListener(eventName, preventDefaults, false);
            });
            
            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                label.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                label.addEventListener(eventName, unhighlight, false);
            });
            
            // Handle dropped files
            label.addEventListener('drop', handleDrop, false);
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            function highlight() {
                label.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
            }
            
            function unhighlight() {
                label.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900');
            }
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                input.files = files;
                
                // Trigger change event
                const event = new Event('change');
                input.dispatchEvent(event);
            }
        }
        
        // Set up drag and drop for the first form
        setupDragAndDrop('gambar-koi-0', 'label[for="gambar-koi-0"]');
        setupDragAndDrop('sertifikat-koi-0', 'label[for="sertifikat-koi-0"]');
        setupDragAndDrop('video-koi-0', 'label[for="video-koi-0"]');
    </script>
</x-app-layout>