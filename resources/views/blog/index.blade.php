@extends('layouts.app')

@section('title', 'Blogs')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .gallery-preview { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px; }
        .gallery-preview img { height: 60px; object-fit: cover; border-radius: 4px; }
        .gallery-item { position: relative; display: inline-block; }
        .remove-gallery { position: absolute; top: -6px; right: -6px; background: red; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 10px; cursor: pointer; }
    </style>
@endpush

@section('content')
    <div class="flex justify-between flex-wrap items-center mb-6">
        <h4 class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-4 sm:mb-0">
            Blogs
        </h4>
        <div class="flex sm:space-x-4 space-x-2 sm:justify-end items-center rtl:space-x-reverse">
            <button type="button" class="btn inline-flex justify-center bg-white text-slate-700 dark:bg-slate-700 dark:text-white"
                    data-bs-toggle="modal" data-bs-target="#createBlogModal">
                <span class="flex items-center">
                    <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2 font-light" icon="heroicons-outline:plus"></iconify-icon>
                    <span>Tambah Blog</span>
                </span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4 flash-alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4 flash-alert">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- LIST BLOGS --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($blogs as $blog)
            <div class="card">
                <div class="card-body p-6">
                    <div class="w-full h-52 mb-4 rounded overflow-hidden">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Featured" class="w-full h-full object-cover">
                    </div>
                    <h5 class="text-lg font-semibold text-slate-800">{{ $blog->title }}</h5>
                    <div class="mt-2 text-sm text-slate-300 line-clamp-2">
                        {{-- {!! strip_tags($blog->content) !!} --}}
                        {{ Str::words(strip_tags($blog->content), 10, ' . . . . . ') }}
                    </div>
                    <div class="mt-2 text-sm line-clamp-2">
                        <a href="{{ route('blogs.show', $blog->id) }}" class="text-slate-400 hover:text-slate-500 hover:underline">
                            Learn more!
                        </a>
                    </div>
                    {{-- <div class="mt-4 flex space-x-2">
                        <button type="button"
                                class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#updateBlogModal"
                                data-blog='{{ json_encode([
                                    "id" => $blog->id,
                                    "title" => $blog->title,
                                    "content" => $blog->content,
                                    "featured_image" => $blog->featured_image,
                                    "gallery" => $blog->images->pluck("img_path")->toArray()
                                ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) }}'
                                >
                            Edit
                        </button>
                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus blog ini?')">
                                Hapus
                            </button>
                        </form>
                    </div> --}}
                </div>
            </div>
        @endforeach
    </div>

    {{-- CREATE MODAL --}}
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="createBlogModal" tabindex="-1">
        <div class="modal-dialog relative w-auto pointer-events-none max-w-2xl mx-auto top-1/3">
            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:bg-slate-900 bg-clip-padding rounded-md outline-none text-current">
                <form method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700 rounded-t-md">
                        <h5 class="text-xl font-medium text-slate-800 dark:text-slate-200">Tambah Blog Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-6">
                        <div class="mb-4">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Title</label>
                            <input type="text" name="title" class="form-control w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Content</label>
                            <textarea name="content" id="summernote-create"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Featured Image</label>
                            <input type="file" name="featured_image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Gallery Images</label>
                            <div id="galleryContainer">
                                <div class="flex items-center mb-2">
                                    <input type="file" name="gallery_images[]" class="form-control flex-1" accept="image/*">
                                    <button type="button" class="ml-2 text-red-500 hover:text-red-700 remove-gallery-file" style="display: none;">
                                        <iconify-icon icon="heroicons:minus-circle"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="addGallery" class="text-sm text-primary-500 hover:text-primary-700 flex items-center mt-2">
                                <iconify-icon icon="heroicons-outline:plus-circle" class="mr-1"></iconify-icon>
                                Tambah Gambar
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-6 border-t border-slate-200 dark:border-slate-700 rounded-b-md">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- UPDATE MODAL --}}
    <div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto" id="updateBlogModal" tabindex="-1">
        <div class="modal-dialog relative w-auto pointer-events-none max-w-2xl mx-auto top-1/4">
            <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white dark:bg-slate-900 bg-clip-padding rounded-md outline-none text-current">
                <form method="POST" action="" enctype="multipart/form-data" id="updateForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="modal-header flex flex-shrink-0 items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700 rounded-t-md">
                        <h5 class="text-xl font-medium text-slate-800 dark:text-slate-200">Edit Blog</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body relative p-6">
                        <div class="mb-4">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Title</label>
                            <input type="text" name="title" id="edit-title" class="form-control w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Content</label>
                            <textarea name="content" id="summernote-update"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Ganti Featured Image (opsional)</label>
                            <input type="file" name="featured_image" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-4">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Gallery Images</label>
                            <div class="gallery-preview" id="edit-gallery-preview"></div>
                            <div id="editGalleryContainer" class="mt-2">
                                <!-- Existing gallery files from DB akan di-load sebagai hidden input -->
                                <input type="hidden" name="existing_gallery[]" value=""> <!-- placeholder -->
                            </div>
                            <button type="button" id="addEditGallery" class="text-sm text-primary-500 hover:text-primary-700 flex items-center mt-2">
                                <iconify-icon icon="heroicons-outline:plus-circle" class="mr-1"></iconify-icon>
                                Tambah Gambar
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-6 border-t border-slate-200 dark:border-slate-700 rounded-b-md">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary ml-2">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
        // === SUMMERNOTE ===
        $('#summernote-create').summernote({ height: 200 });
        $('#summernote-update').summernote({ height: 200 });

        // === CREATE: DYNAMIC GALLERY ===
        function addGalleryField(containerId) {
            const container = document.getElementById(containerId);
            const newField = document.createElement('div');
            newField.className = 'flex items-center mb-2';
            newField.innerHTML = `
                <input type="file" name="gallery_images[]" class="form-control flex-1" accept="image/*" required>
                <button type="button" class="ml-2 text-red-500 hover:text-red-700 remove-gallery-file">
                    <iconify-icon icon="heroicons:minus-circle"></iconify-icon>
                </button>
            `;
            container.appendChild(newField);
        }

        document.getElementById('addGallery').addEventListener('click', () => {
            addGalleryField('galleryContainer');
        });

        // === UPDATE: LOAD BLOG DATA ===
        document.querySelectorAll('[data-bs-target="#updateBlogModal"]').forEach(btn => {
            btn.addEventListener('click', function() {
                const blog = JSON.parse(this.dataset.blog);
                const form = document.getElementById('updateForm');
                form.action = `/blogs/${blog.id}`;

                document.getElementById('edit-id').value = blog.id;
                document.getElementById('edit-title').value = blog.title;
                $('#summernote-update').summernote('code', blog.content);

                // Preview gambar existing
                const preview = document.getElementById('edit-gallery-preview');
                preview.innerHTML = '';
                const existingContainer = document.getElementById('editGalleryContainer');
                existingContainer.innerHTML = '';

                blog.gallery.forEach(path => {
                    const img = document.createElement('div');
                    img.className = 'gallery-item';
                    img.innerHTML = `
                        <img src="${assetStorage(path)}" alt="Gallery">
                        <span class="remove-gallery" data-path="${path}">×</span>
                    `;
                    preview.appendChild(img);

                    // Simpan path existing sebagai hidden input (biar controller tau gambar lama tetap ada)
                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'existing_gallery[]';
                    hidden.value = path;
                    existingContainer.appendChild(hidden);
                });
            });
        });

        function assetStorage(path) {
            return path.startsWith('http') ? path : `/storage/${path}`;
        }

        // === UPDATE: TAMBAH GAMBAR BARU ===
        document.getElementById('addEditGallery').addEventListener('click', () => {
            const container = document.getElementById('editGalleryContainer');
            const newField = document.createElement('div');
            newField.className = 'flex items-center mb-2';
            newField.innerHTML = `
                <input type="file" name="new_gallery_images[]" class="form-control flex-1" accept="image/*">
                <button type="button" class="ml-2 text-red-500 hover:text-red-700 remove-gallery-file">
                    <iconify-icon icon="heroicons:minus-circle"></iconify-icon>
                </button>
            `;
            container.appendChild(newField);
        });

        // === HAPUS GAMBAR (existing atau field baru) ===
        document.addEventListener('click', function(e) {
            // Hapus field input gallery (baru)
            if (e.target.closest('.remove-gallery-file')) {
                e.target.closest('.flex').remove();
            }

            // Hapus preview gallery existing (akan di-handle di controller via 'deleted_gallery')
            if (e.target.closest('.remove-gallery')) {
                const span = e.target.closest('.remove-gallery');
                const path = span.dataset.path;
                const item = span.closest('.gallery-item');

                // Tambah hidden input untuk gambar yang dihapus
                const form = document.getElementById('updateForm');
                let hidden = form.querySelector('input[name="deleted_gallery"]');
                if (!hidden) {
                    hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'deleted_gallery';
                    form.appendChild(hidden);
                }
                hidden.value = hidden.value ? hidden.value + ',' + path : path;

                item.remove();
            }
        });

        // === AUTO HIDE FLASH ALERT ===
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.flash-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('opacity-0', 'transition', 'duration-500');
                    setTimeout(() => alert.remove(), 600);
                }, 4000);
            });
        });
    </script>
@endpush
