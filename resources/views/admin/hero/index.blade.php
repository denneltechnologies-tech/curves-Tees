@extends('admin.layouts.app')

@section('title', 'Hero Section & Media Showcase')

@section('content')
<div class="page-head">
    <div>
        <h2 class="page-title">Hero Section & Media Showcase</h2>
        <div class="muted">Manage the homepage hero headline, lookbook carousel slides, and runway video reel.</div>
    </div>
    <div class="toolbar">
        <a href="{{ route('store.index') }}" target="_blank" class="btn btn-secondary btn-sm">
            👁️ Preview Storefront
        </a>
    </div>
</div>

@if(session('status'))
    <div class="alert alert-success">
        ✓ {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        <div>
            <strong>Please correct the following errors:</strong>
            <ul style="margin: 6px 0 0 18px;">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="grid-2" style="grid-template-columns: 1.1fr 1fr; gap: 24px; margin-bottom: 28px;">
    <!-- Global Hero & Video Settings Card -->
    <div class="card">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
            <h3 style="font-size: 16px; font-weight: 700; color: #181513; display: flex; align-items: center; gap: 8px;">
                <span>🎬</span> Hero Content & Video Reel Settings
            </h3>
            <span class="badge badge-gold">Homepage Header</span>
        </div>

        <form action="{{ route('admin.hero.settings') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="hero_badge">Hero Top Badge Tag</label>
                <input type="text" id="hero_badge" name="hero_badge" value="{{ old('hero_badge', $settings['hero_badge']) }}" placeholder="e.g. NEW COLLECTION • READY-TO-WEAR">
                <div class="hint">Appears in small gold caps above the main headline.</div>
            </div>

            <div class="form-group">
                <label for="hero_title">Main Headline</label>
                <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', $settings['hero_title']) }}" required placeholder="e.g. Accra's Premier Destination for *Curve-Flattering* Luxury">
                <div class="hint">Wrap any phrase in asterisks (e.g. <code>*Curve-Flattering*</code>) to highlight it in gold italic serif.</div>
            </div>

            <div class="form-group">
                <label for="hero_subtitle">Hero Subtitle</label>
                <textarea id="hero_subtitle" name="hero_subtitle" rows="3" placeholder="Description of your boutique...">{{ old('hero_subtitle', $settings['hero_subtitle']) }}</textarea>
            </div>

            <div style="background: #faf8f5; border: 1.5px dashed #d9a044; border-radius: 12px; padding: 18px; margin: 20px 0;">
                <div style="font-weight: 700; color: #78350f; font-size: 14px; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
                    <span>🎥</span> Runway Lookbook Video Source
                </div>

                <div class="form-group" style="margin-bottom: 14px;">
                    <label for="hero_video_url" style="color: #181513;">Video URL or Google Drive Link</label>
                    <input type="text" id="hero_video_url" name="hero_video_url" value="{{ old('hero_video_url', $settings['hero_video_url']) }}" placeholder="Paste Google Drive share link, YouTube, or MP4 URL">
                    <div class="hint" style="color: #6b7280;">
                        💡 <strong>How to add a Google Drive Video:</strong><br>
                        1. In Google Drive, right-click your fashion video and click <strong>Share</strong>.<br>
                        2. Change General Access to <strong>"Anyone with the link can view"</strong>.<br>
                        3. Copy the link and paste it here! We automatically convert it to stream directly.
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 14px;">
                    <label for="hero_video_file" style="color: #181513;">Or Upload Video File Directly (.mp4, .webm, up to 50MB)</label>
                    <input type="file" id="hero_video_file" name="hero_video_file" accept="video/mp4,video/webm,video/quicktime">
                    <div class="hint">Upload your boutique video reel directly from your phone or computer.</div>
                </div>

                <div class="grid-2" style="gap: 12px; margin-top: 10px;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="hero_video_title">Video Title</label>
                        <input type="text" id="hero_video_title" name="hero_video_title" value="{{ old('hero_video_title', $settings['hero_video_title']) }}" placeholder="Curves & Tees • Lookbook">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="hero_mode">Hero Display Mode</label>
                        <select id="hero_mode" name="hero_mode">
                            <option value="both" {{ old('hero_mode', $settings['hero_mode']) === 'both' ? 'selected' : '' }}>Photo Carousel + Watch Video Button</option>
                            <option value="carousel_only" {{ old('hero_mode', $settings['hero_mode']) === 'carousel_only' ? 'selected' : '' }}>Photo Carousel Only</option>
                            <option value="video_primary" {{ old('hero_mode', $settings['hero_mode']) === 'video_primary' ? 'selected' : '' }}>Video Reel as Primary Visual</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="text-align: right; margin-top: 20px;">
                <button type="submit" class="btn btn-gold" style="padding: 11px 24px;">
                    💾 Save Hero Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Video Preview & Quick Info Card -->
    <div class="card">
        <h3 style="margin-bottom: 14px; font-size: 16px; font-weight: 700; color: #181513;">
            🎬 Live Video Reel Preview
        </h3>
        <p class="muted" style="margin-bottom: 14px;">This is the video reel that customers see when clicking "Watch Runway Video" in the hero section.</p>

        @if(!empty($settings['hero_video_url']))
            <div style="background: #000; border-radius: 14px; overflow: hidden; position: relative; aspect-ratio: 16/9; box-shadow: 0 8px 24px rgba(0,0,0,0.2);">
                @php
                    $url = $settings['hero_video_url'];
                    $isGdrive = preg_match('#drive\.google\.com/file/d/([a-zA-Z0-9_-]+)#', $url, $gmatches);
                    $isYoutube = preg_match('#(?:youtube\.com/(?:watch\?v=|embed/)|youtu\.be/)([a-zA-Z0-9_-]+)#', $url, $ymatches);
                @endphp

                @if($isGdrive)
                    <iframe src="https://drive.google.com/file/d/{{ $gmatches[1] }}/preview" width="100%" height="100%" allow="autoplay" style="border: none;"></iframe>
                @elseif($isYoutube)
                    <iframe src="https://www.youtube.com/embed/{{ $ymatches[1] }}" width="100%" height="100%" allow="autoplay; encrypted-media" style="border: none;"></iframe>
                @else
                    <video src="{{ $url }}" controls playsinline style="width: 100%; height: 100%; object-fit: cover;"></video>
                @endif
            </div>
            <div style="margin-top: 12px; font-size: 13px; color: #4b5563; display: flex; justify-content: space-between; align-items: center;">
                <span><strong>Active Video Source:</strong> {{ Str::limit($settings['hero_video_url'], 45) }}</span>
                <span class="badge badge-success">Live Ready</span>
            </div>
        @else
            <div style="background: #f3f4f6; border-radius: 14px; border: 2px dashed #d1d5db; padding: 40px 20px; text-align: center; color: #6b7280;">
                <div style="font-size: 36px; margin-bottom: 8px;">📹</div>
                <div style="font-weight: 600;">No video configured yet</div>
                <div style="font-size: 12px; margin-top: 4px;">Paste a Google Drive link or upload an MP4 above to activate the video reel.</div>
            </div>
        @endif

        <div style="margin-top: 24px; padding: 16px; background: #fdf5e6; border: 1px solid #f6deb3; border-radius: 12px;">
            <h4 style="font-size: 13px; font-weight: 700; color: #9c6c1b; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.8px;">
                💡 Tips for Best Visual Results
            </h4>
            <ul style="font-size: 12.5px; color: #6b4b12; line-height: 1.6; margin-left: 18px;">
                <li><strong>Editorial Slides:</strong> Use high-resolution photography (recommended 1200 x 900 or 1200 x 800px).</li>
                <li><strong>Video Length:</strong> 15 to 60-second video clips showcasing model walks, fabric movement, and outfit fitting create the highest customer engagement.</li>
                <li><strong>Dynamic Lookbook:</strong> Slides transition smoothly every 5 seconds on the homepage with an interactive progress indicator.</li>
            </ul>
        </div>
    </div>
</div>

<!-- Slides Manager -->
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h3 style="font-size: 18px; font-weight: 700; color: #181513; margin-bottom: 2px;">
                🖼️ Hero Lookbook Carousel Slides ({{ $slides->count() }})
            </h3>
            <div class="muted">These slides rotate dynamically on the right half of your homepage hero section.</div>
        </div>
        <button type="button" class="btn btn-gold btn-sm" onclick="document.getElementById('addSlideModal').style.display='flex'">
            + Add New Hero Slide
        </button>
    </div>

    @if($slides->isEmpty())
        <div style="text-align: center; padding: 40px 20px; color: #6b7280;">
            <p>No hero slides created yet. Click "+ Add New Hero Slide" to create your first lookbook slide.</p>
        </div>
    @else
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
            @foreach($slides as $slide)
                <div style="border: 1px solid #e5e7eb; border-radius: 16px; overflow: hidden; background: #fff; display: flex; flex-direction: column; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: transform .15s ease;">
                    <div style="position: relative; height: 210px; background: #191614; overflow: hidden;">
                        <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.65); backdrop-filter: blur(4px); color: #f5d496; border: 1px solid rgba(229,184,143,0.4); font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 30px;">
                            {{ $slide->tag ?: 'HERO SLIDE' }}
                        </div>
                        <div style="position: absolute; top: 10px; right: 10px;">
                            <form action="{{ route('admin.hero.slides.toggle', $slide) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="badge {{ $slide->is_active ? 'badge-success' : 'badge-danger' }}" style="cursor: pointer; border: none;">
                                    {{ $slide->is_active ? '● Active' : '○ Inactive' }}
                                </button>
                            </form>
                        </div>
                        <div style="position: absolute; bottom: 0; inset-inline: 0; background: linear-gradient(to top, rgba(0,0,0,0.85), transparent); padding: 14px; color: #fff;">
                            <h4 style="font-family: Georgia, serif; font-size: 17px; margin-bottom: 3px; color: #faf6f0;">{{ $slide->title }}</h4>
                            <p style="font-size: 12px; color: #d1d5db; margin: 0;">{{ Str::limit($slide->subtitle, 65) }}</p>
                        </div>
                    </div>

                    <div style="padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                        <div style="font-size: 12.5px; color: #4b5563; margin-bottom: 12px;">
                            <div><strong>Button:</strong> "{{ $slide->button_text }}" &rarr; <code>{{ $slide->button_link }}</code></div>
                            <div style="margin-top: 4px;"><strong>Order:</strong> #{{ $slide->sort_order }}</div>
                        </div>

                        <div style="display: flex; gap: 8px; border-top: 1px solid #f3f4f6; padding-top: 12px;">
                            <button type="button" class="btn btn-secondary btn-sm" style="flex: 1;" onclick="openEditModal({{ $slide->id }}, '{{ addslashes($slide->title) }}', '{{ addslashes($slide->subtitle ?? '') }}', '{{ addslashes($slide->tag ?? '') }}', '{{ addslashes($slide->image_path) }}', '{{ addslashes($slide->button_text) }}', '{{ addslashes($slide->button_link) }}', {{ $slide->sort_order }}, {{ $slide->is_active ? 1 : 0 }})">
                                ✏️ Edit
                            </button>
                            <form action="{{ route('admin.hero.slides.destroy.post', $slide) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this slide?');">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete slide" style="cursor: pointer; padding: 6px 12px;">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal: Add New Slide -->
<div id="addSlideModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #fff; border-radius: 18px; width: 100%; max-width: 580px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(0,0,0,0.3); border: 1px solid #e5e7eb;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: #181513;">+ Add New Hero Slide</h3>
            <button type="button" onclick="document.getElementById('addSlideModal').style.display='none'" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #9ca3af;">&times;</button>
        </div>

        <form action="{{ route('admin.hero.slides.store') }}" method="POST" enctype="multipart/form-data" style="padding: 24px;">
            @csrf

            <div class="form-group">
                <label for="new_title">Slide Title *</label>
                <input type="text" id="new_title" name="title" required placeholder="e.g. The Accra Luxury Silhouette">
            </div>

            <div class="form-group">
                <label for="new_subtitle">Slide Subtitle</label>
                <input type="text" id="new_subtitle" name="subtitle" placeholder="e.g. Sculpted tailoring crafted for confident everyday elegance.">
            </div>

            <div class="grid-2" style="gap: 12px;">
                <div class="form-group">
                    <label for="new_tag">Badge Tag</label>
                    <input type="text" id="new_tag" name="tag" placeholder="e.g. EDITORIAL • SS26">
                </div>
                <div class="form-group">
                    <label for="new_sort_order">Display Order</label>
                    <input type="number" id="new_sort_order" name="sort_order" value="{{ $slides->count() + 1 }}">
                </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 18px;">
                <div style="font-weight: 600; font-size: 13.5px; margin-bottom: 10px; color: #334155;">Slide Image (Upload file OR Image URL)</div>
                <div class="form-group" style="margin-bottom: 12px;">
                    <label for="new_image">Upload Image File (JPG, PNG, WebP)</label>
                    <input type="file" id="new_image" name="image" accept="image/*">
                </div>
                <div style="text-align: center; font-size: 12px; color: #94a3b8; margin: -6px 0 8px;">— OR —</div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="new_image_url">Image Web URL</label>
                    <input type="text" id="new_image_url" name="image_url" placeholder="https://example.com/photo.jpg">
                </div>
            </div>

            <div class="grid-2" style="gap: 12px;">
                <div class="form-group">
                    <label for="new_btn_text">Button Text *</label>
                    <input type="text" id="new_btn_text" name="button_text" value="Explore Collection" required>
                </div>
                <div class="form-group">
                    <label for="new_btn_link">Button Link *</label>
                    <input type="text" id="new_btn_link" name="button_link" value="#catalog" required>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('addSlideModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Publish Slide</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal: Edit Slide -->
<div id="editSlideModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #fff; border-radius: 18px; width: 100%; max-width: 580px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(0,0,0,0.3); border: 1px solid #e5e7eb;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #f1f5f9;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: #181513;">✏️ Edit Hero Slide</h3>
            <button type="button" onclick="document.getElementById('editSlideModal').style.display='none'" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #9ca3af;">&times;</button>
        </div>

        <form id="editSlideForm" action="" method="POST" enctype="multipart/form-data" style="padding: 24px;">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="edit_title">Slide Title *</label>
                <input type="text" id="edit_title" name="title" required>
            </div>

            <div class="form-group">
                <label for="edit_subtitle">Slide Subtitle</label>
                <input type="text" id="edit_subtitle" name="subtitle">
            </div>

            <div class="grid-2" style="gap: 12px;">
                <div class="form-group">
                    <label for="edit_tag">Badge Tag</label>
                    <input type="text" id="edit_tag" name="tag">
                </div>
                <div class="form-group">
                    <label for="edit_sort_order">Display Order</label>
                    <input type="number" id="edit_sort_order" name="sort_order">
                </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 18px;">
                <div style="font-weight: 600; font-size: 13.5px; margin-bottom: 10px; color: #334155;">Change Slide Image (Optional)</div>
                <div class="form-group" style="margin-bottom: 12px;">
                    <label for="edit_image">Upload New Image File</label>
                    <input type="file" id="edit_image" name="image" accept="image/*">
                </div>
                <div style="text-align: center; font-size: 12px; color: #94a3b8; margin: -6px 0 8px;">— OR —</div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="edit_image_url">Image Web URL</label>
                    <input type="text" id="edit_image_url" name="image_url">
                </div>
            </div>

            <div class="grid-2" style="gap: 12px;">
                <div class="form-group">
                    <label for="edit_btn_text">Button Text *</label>
                    <input type="text" id="edit_btn_text" name="button_text" required>
                </div>
                <div class="form-group">
                    <label for="edit_btn_link">Button Link *</label>
                    <input type="text" id="edit_btn_link" name="button_link" required>
                </div>
            </div>

            <div class="form-group" style="margin-top: 10px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" style="width: auto;">
                    <span>Active and visible on homepage carousel</span>
                </label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; border-top: 1px solid #f1f5f9; padding-top: 16px;">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('editSlideModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Update Slide</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, title, subtitle, tag, imagePath, btnText, btnLink, sortOrder, isActive) {
    var form = document.getElementById('editSlideForm');
    form.action = '/admin/hero/slides/' + id;

    document.getElementById('edit_title').value = title;
    document.getElementById('edit_subtitle').value = subtitle;
    document.getElementById('edit_tag').value = tag;
    document.getElementById('edit_btn_text').value = btnText;
    document.getElementById('edit_btn_link').value = btnLink;
    document.getElementById('edit_sort_order').value = sortOrder;
    document.getElementById('edit_is_active').checked = isActive === 1;

    if (imagePath && imagePath.startsWith('http')) {
        document.getElementById('edit_image_url').value = imagePath;
    } else {
        document.getElementById('edit_image_url').value = '';
    }

    document.getElementById('editSlideModal').style.display = 'flex';
}
</script>
@endsection
