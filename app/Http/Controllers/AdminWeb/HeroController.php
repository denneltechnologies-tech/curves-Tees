<?php

namespace App\Http\Controllers\AdminWeb;

use App\Http\Controllers\Controller;
use App\Models\HeroSetting;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HeroController extends Controller
{
    /**
     * Display hero settings and slides management.
     */
    public function index(): View
    {
        $slides = HeroSlide::orderBy('sort_order', 'asc')->get();

        $settings = [
            'hero_badge' => HeroSetting::get('hero_badge', 'NEW COLLECTION • READY-TO-WEAR'),
            'hero_title' => HeroSetting::get('hero_title', "Accra's Premier Destination for *Curve-Flattering* Luxury"),
            'hero_subtitle' => HeroSetting::get('hero_subtitle', 'Celebrating every curve with sculpted corporate wear, radiant evening silhouettes, luxury party dresses, and signature essentials.'),
            'hero_video_url' => HeroSetting::get('hero_video_url', 'https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-a-photoshoot-wearing-a-red-dress-34440-large.mp4'),
            'hero_video_title' => HeroSetting::get('hero_video_title', 'Curves & Tees • Runway Lookbook'),
            'hero_video_caption' => HeroSetting::get('hero_video_caption', 'Editorial highlights from our latest Accra ready-to-wear showroom release.'),
            'hero_mode' => HeroSetting::get('hero_mode', 'both'),
        ];

        return view('admin.hero.index', compact('slides', 'settings'));
    }

    /**
     * Update global hero settings (including headline and hero video).
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge' => ['nullable', 'string', 'max:150'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['nullable', 'string', 'max:1000'],
            'hero_video_url' => ['nullable', 'string', 'max:1000'],
            'hero_video_title' => ['nullable', 'string', 'max:255'],
            'hero_video_caption' => ['nullable', 'string', 'max:500'],
            'hero_mode' => ['required', 'in:both,carousel_only,video_primary'],
            'hero_video_file' => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:51200'], // 50MB
        ]);

        if ($request->hasFile('hero_video_file')) {
            $path = $request->file('hero_video_file')->store('hero/videos', 'public');
            $validated['hero_video_url'] = asset('storage/' . $path);
        }

        foreach (['hero_badge', 'hero_title', 'hero_subtitle', 'hero_video_url', 'hero_video_title', 'hero_video_caption', 'hero_mode'] as $key) {
            if (array_key_exists($key, $validated)) {
                HeroSetting::set($key, $validated[$key]);
            }
        }

        return redirect()->route('admin.hero.index')->with('status', 'Hero showcase settings saved successfully.');
    }

    /**
     * Store a new hero carousel slide.
     */
    public function storeSlide(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'tag' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'image_url' => ['nullable', 'string', 'max:1000'],
            'video_url' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['required', 'string', 'max:100'],
            'button_link' => ['required', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $imagePath = $validated['image_url'] ?? null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hero/slides', 'public');
        }

        if (empty($imagePath)) {
            return back()->withErrors(['image' => 'Please provide either an image file upload or an image URL.'])->withInput();
        }

        HeroSlide::create([
            'title' => $validated['title'],
            'subtitle' => $validated['subtitle'],
            'tag' => $validated['tag'],
            'media_type' => !empty($validated['video_url']) ? 'video' : 'image',
            'image_path' => $imagePath,
            'video_url' => $validated['video_url'] ?? null,
            'button_text' => $validated['button_text'],
            'button_link' => $validated['button_link'],
            'sort_order' => (int) ($validated['sort_order'] ?? HeroSlide::count() + 1),
            'is_active' => true,
        ]);

        return redirect()->route('admin.hero.index')->with('status', 'New hero slide added successfully.');
    }

    /**
     * Update an existing hero slide.
     */
    public function updateSlide(Request $request, HeroSlide $slide): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'tag' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'image_url' => ['nullable', 'string', 'max:1000'],
            'video_url' => ['nullable', 'string', 'max:1000'],
            'button_text' => ['required', 'string', 'max:100'],
            'button_link' => ['required', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($slide->image_path && !str_starts_with($slide->image_path, 'http')) {
                Storage::disk('public')->delete($slide->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('hero/slides', 'public');
        } elseif (!empty($validated['image_url'])) {
            $validated['image_path'] = $validated['image_url'];
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['media_type'] = !empty($validated['video_url']) ? 'video' : 'image';

        $slide->update($validated);

        return redirect()->route('admin.hero.index')->with('status', 'Hero slide updated successfully.');
    }

    /**
     * Toggle slide active state.
     */
    public function toggleSlide(HeroSlide $slide): RedirectResponse
    {
        $slide->update(['is_active' => !$slide->is_active]);

        return redirect()->route('admin.hero.index')->with('status', 'Slide visibility updated.');
    }

    /**
     * Delete a hero slide.
     */
    public function destroySlide(HeroSlide $slide): RedirectResponse
    {
        if ($slide->image_path && !str_starts_with($slide->image_path, 'http')) {
            Storage::disk('public')->delete($slide->image_path);
        }

        $slide->delete();

        return redirect()->route('admin.hero.index')->with('status', 'Hero slide removed.');
    }
}
