<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Models\Blog;
use App\Models\BlogImages;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $blogs = Blog::with('images')->latest()->get();
            return view('blog.index', compact('blogs'));
        } catch (Exception $e){
            Log::info('failed to get blog index' ,[
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogStoreRequest $request)
    {
        try{
            $request->validated();

            $featuredImgPath = $request->file('featured_image')->store('/blogs/featured', 'public');

            $blog = Blog::create([
                'title' => $request->title,
                'content' => $request->content,
                'featured_image' => $featuredImgPath
            ]);

            if($request->hasFile('gallery_images')){
                foreach($request->file('gallery_images') as $image){
                    $path = $image->store('blogs/gallery', 'public');
                    BlogImages::create([
                        'blog_id' => $blog->id,
                        'img_path' => $path
                    ]);
                }
            }

            return redirect()->back()->with('success', 'new blog created!');
        } catch(Exception $e){
            Log::info('created blog error' ,[
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        try{
            $blog->load('images');
            return view('blog.show', compact('blog'));
        } catch (Exception $e){
            Log::info('error showing blog' ,[
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, Blog $blog)
    {
        try {
            $request->validated();

            // Handle featured image
            if ($request->hasFile('featured_image')) {
                Storage::disk('public')->delete($blog->featured_image);
                $blog->featured_image = $request->file('featured_image')->store('/blogs/featured', 'public');
            }

            $blog->update($request->only('title', 'content'));

            // Hapus gallery yang dipilih
            if ($request->filled('deleted_gallery')) {
                $deletedPaths = explode(',', $request->deleted_gallery);
                foreach ($deletedPaths as $path) {
                    Storage::disk('public')->delete($path);
                    BlogImages::where('blog_id', $blog->id)->where('img_path', $path)->delete();
                }
            }

            // Tambah gallery baru (dari form update)
            if ($request->hasFile('new_gallery_images')) {
                foreach ($request->file('new_gallery_images') as $image) {
                    $path = $image->store('blogs/gallery', 'public');
                    BlogImages::create(['blog_id' => $blog->id, 'img_path' => $path]);
                }
            }

            return redirect()->back()->with('success', 'Blog updated successfully!');
        } catch (Exception $e) {
            Log::info('updated blog error', [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
            return redirect()->back()->with('error', 'Gagal mengupdate blog.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try{
            Storage::disk('public')->delete($blog->featured_image);

            foreach($blog->images as $img){
                Storage::disk('public')->delete($img->img_path);
                $img->delete();
            }

            $blog->delete();

            return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully!');
        } catch(Exception $e){
            Log::info('Deleted blog error' ,[
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ]);
        }
    }
}
