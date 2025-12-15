@extends('layouts.app')

@section('title', $blog->title)

@push('styles')
    <!-- Summernote (opsional, cuma buat modal edit) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .blog-content h1, .blog-content h2, .blog-content h3 {
            @apply text-2xl md:text-3xl font-bold mb-4 mt-6;
        }
        .blog-content p {
            @apply mb-4 text-slate-700 dark:text-slate-300;
        }
        .remove-gallery{
            position: absolute;
            top: -6px;
            right: -6px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            cursor: pointer; /* 👈 ini biar jadi pointer */
            z-index: 10;
        }
        .blog-content img {
            @apply rounded-lg my-4 max-w-full h-auto;
        }
        .blog-content ul, .blog-content ol {
            @apply mb-4 pl-6;
        }
        .blog-content li {
            @apply mb-1;
        }
        .blog-img-wrapper {
            max-width: 320px;
            margin: 0 auto;
        }
        .blog-img-wrapperr {
            max-width: 240px;
            margin: 0 auto;
        }
    </style>
@endpush

@section('content')
    <div class="flex justify-between flex-wrap items-center mb-6">
        <h4 class="font-medium lg:text-2xl text-xl capitalize text-slate-900 inline-block ltr:pr-4 rtl:pl-4 mb-4 sm:mb-0">
            {{ $blog->title }}
        </h4>
        <div class="flex sm:space-x-4 space-x-2 sm:justify-end items-center rtl:space-x-reverse">
            <a href="{{ route('blogs.index') }}" class="btn inline-flex justify-center bg-white text-slate-700 dark:bg-slate-700 dark:text-white">
                <span class="flex items-center">
                    <iconify-icon class="text-xl ltr:mr-2 rtl:ml-2 font-light" icon="heroicons-outline:arrow-left"></iconify-icon>
                    <span>Kembali</span>
                </span>
            </a>
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
                    ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) }}'>
                Edit
            </button>
            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus blog ini?')">
                    Hapus
                </button>
            </form>
        </div>
    </div>


    <!-- list blog -->
    <div class="card">
        <div class="card-body p-6">
            <!-- Featured Image -->
            <div class="mb-6 rounded overflow-hidden blog-img-wrapper">
                <img src="{{ asset('storage/' . $blog->featured_image) }}"
                     alt="{{ $blog->title }}"
                     class="w-full h-auto object-cover">
            </div>

            <!-- Konten Blog -->
            <div class="blog-content mt-6">
                {!! $blog->content !!}
            </div>

            <!-- Gallery Slider -->
            @if($blog->images->isNotEmpty())
                <div class="mt-8">
                    <h5 class="text-lg font-semibold mb-4">Gallery</h5>
                    <div class="swiper blog-gallery-swiper">
                        <div class="swiper-wrapper">
                            @foreach($blog->images as $image)
                                <div class="swiper-slide blog-img-wrapperr">
                                    <img src="{{ asset('storage/' . $image->img_path) }}"
                                         alt="Gallery"
                                         class="w-full h-64 object-cover rounded">
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            @endif
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
                                <input type="hidden" name="existing_gallery[]" value="">
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
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // === SWIPER ===
        document.addEventListener('DOMContentLoaded', function () {
            if (document.querySelector('.blog-gallery-swiper')) {
                new Swiper('.blog-gallery-swiper', {
                    loop: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    spaceBetween: 10,
                    slidesPerView: 1,
                    breakpoints: {
                        640: { slidesPerView: 2 },
                        1024: { slidesPerView: 3 }
                    }
                });
            }
        });

        // === HELPER ===
        function assetStorage(path) {
            return path.startsWith('http') ? path : `/storage/${path}`;
        }

        // === DYNAMIC GALLERY (UPDATE) ===
        function addEditGalleryField() {
            const container = document.getElementById('editGalleryContainer');
            if (!container) return;
            const newField = document.createElement('div');
            newField.className = 'flex items-center mb-2';
            newField.innerHTML = `
                <input type="file" name="new_gallery_images[]" class="form-control flex-1" accept="image/*">
                <button type="button" class="ml-2 text-red-500 hover:text-red-700 remove-gallery-file">
                    <iconify-icon icon="heroicons:minus-circle"></iconify-icon>
                </button>
            `;
            container.appendChild(newField);
        }

        // === EVENT DELEGATION ===
        document.addEventListener('click', function(e) {
            // Tambah gallery
            if (e.target.id === 'addEditGallery') {
                addEditGalleryField();
            }

            // Hapus field baru
            if (e.target.closest('.remove-gallery-file')) {
                e.target.closest('.flex').remove();
            }

            // Hapus gambar existing
            if (e.target.closest('.remove-gallery')) {
                const span = e.target.closest('.remove-gallery');
                const path = span.dataset.path;
                const item = span.closest('.gallery-item');

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

            // Buka modal edit
            const editBtn = e.target.closest('[data-bs-target="#updateBlogModal"]');
            if (editBtn) {
                const blog = JSON.parse(editBtn.dataset.blog);
                const form = document.getElementById('updateForm');
                form.action = `/blogs/${blog.id}`;

                document.getElementById('edit-id').value = blog.id;
                document.getElementById('edit-title').value = blog.title;

                // Re-init Summernote
                if ($('#summernote-update').hasClass('note-editor')) {
                    $('#summernote-update').summernote('destroy');
                }
                $('#summernote-update').val(blog.content).summernote({ height: 200 });

                // Preview gallery
                const preview = document.getElementById('edit-gallery-preview');
                const container = document.getElementById('editGalleryContainer');
                preview.innerHTML = '';
                container.innerHTML = '';

                blog.gallery.forEach(path => {
                    const div = document.createElement('div');
                    div.className = 'gallery-item inline-block relative mr-2 mb-2';
                    div.innerHTML = `
                        <img src="${assetStorage(path)}" alt="Gallery" class="h-12 object-cover rounded">
                        <span class="remove-gallery absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs" data-path="${path}">×</span>
                    `;
                    preview.appendChild(div);

                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'existing_gallery[]';
                    hidden.value = path;
                    container.appendChild(hidden);
                });
            }
        });
    </script>
@endpush
