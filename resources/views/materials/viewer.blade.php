<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $material->title }} - Viewer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #viewer-container {
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
        #file-frame {
            flex: 1;
            border: none;
        }
    </style>
</head>
<body class="bg-gray-900">
    <div id="viewer-container">
        <!-- Header Bar -->
        <div class="bg-gradient-to-r from-red-600 to-rose-700 px-6 py-4 flex items-center justify-between shadow-xl">
            <div class="flex items-center space-x-4">
                <a href="{{ Auth::user()->role === 'teacher' ? route('materials.teacher.index') : route('materials.student.index') }}" 
                   class="text-white hover:text-red-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-white font-bold text-lg">{{ $material->title }}</h1>
                    <p class="text-red-100 text-sm">{{ $material->subject->name }}</p>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <span class="text-white text-sm font-medium px-3 py-1 bg-white/20 rounded-lg">
                    {{ strtoupper($extension) }}
                </span>
                {{-- Fixed: Use role-specific download route --}}
                <a href="{{ Auth::user()->role === 'teacher' ? route('materials.teacher.download', $material) : route('materials.student.download', $material) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white text-red-600 font-bold rounded-lg hover:bg-red-50 transition-all duration-200 shadow-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download
                </a>
            </div>
        </div>

<!-- File Viewer -->
<!-- File Viewer -->
@if(in_array($extension, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
    <!-- Office Documents - Use Microsoft Office Online Viewer -->
    <iframe
        src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode(route('materials.serve', $material)) }}"
        width="100%"
        height="100%"
        frameborder="0"
        style="border: none;">
        <p>This browser does not support iframes. <a target="_blank" href="https://office.com">Download Microsoft Office</a> to view this document.</p>
    </iframe>
    
@elseif(in_array($extension, ['pdf']))
    <!-- PDF Viewer -->
    <iframe id="file-frame" 
            src="{{ route('materials.serve', $material) }}" 
            class="w-full h-full">
    </iframe>
    
@elseif(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']))
    <!-- Image Viewer -->
    <div class="flex-1 flex items-center justify-center bg-gray-800 p-8 overflow-auto">
        <img src="{{ route('materials.serve', $material) }}" 
             alt="{{ $material->title }}" 
             class="max-w-full max-h-full object-contain shadow-2xl">
    </div>
    
@elseif(in_array($extension, ['txt']))
    <!-- Text File Viewer -->
    <iframe id="file-frame" 
            src="{{ route('materials.serve', $material) }}" 
            class="w-full h-full bg-white">
    </iframe>
    
@else
    <!-- Unsupported file type -->
    <div class="flex-1 flex items-center justify-center bg-gray-800">
        <div class="text-center p-8">
            <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="text-white text-xl font-bold mb-2">Preview Not Available</h3>
            <p class="text-gray-400 mb-6">This file type cannot be previewed in the browser</p>
            <a href="{{ Auth::user()->role === 'teacher' ? route('materials.teacher.download', $material) : route('materials.student.download', $material) }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-rose-700 text-white font-bold rounded-xl hover:from-red-700 hover:to-rose-800 transition-all duration-200 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download File
            </a>
        </div>
    </div>
@endif
    </div>

    <script>
        // Prevent right-click on images (optional security measure)
        document.addEventListener('contextmenu', function(e) {
            if (e.target.tagName === 'IMG') {
                e.preventDefault();
            }
        });

        // Handle iframe loading errors
        const iframe = document.getElementById('file-frame');
        if (iframe) {
            iframe.addEventListener('error', function() {
                console.error('Failed to load file');
            });
        }
    </script>
</body>
</html>