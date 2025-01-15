<div class="w-full flex flex-col justify-center items-center h-full"
     x-data="{
            loading: true,
            autoplayed: false,

            init() {
                this.loading = true;
                let mediaElement = this.$refs.mediaFrame;

                if (!mediaElement) {
                    this.loading = false;
                    return;
                }

                if (mediaElement.tagName === 'VIDEO' || mediaElement.tagName === 'AUDIO') {
                    mediaElement.load();

                    mediaElement.onload = () => {
                        this.loading = false;
                    };
                    mediaElement.oncanplaythrough = () => {
                        this.loading = false;
                    };
                    mediaElement.onloadstart = () => {
                        this.loading = true;
                    };
                    mediaElement.onerror = () => {
                        this.loading = false;
                    };

                    if (mediaElement.readyState >= 3) {
                        this.loading = false;
                    }

                    // Autoplay logic
                    if (@js($autoplay) && mediaElement.play) {
                        this.autoplayed = true;
                        mediaElement.play().catch(() => {
                            console.log('Autoplay failed or was blocked.');
                        });
                    }
                } else {
                    this.loading = true;

                    mediaElement.onload = () => {
                        setTimeout(() => {
                            this.loading = false;
                        }, 200);
                    };
                    mediaElement.onerror = () => {
                        this.loading = false;
                    };
                }
            },

            resetAutoplay() {
                this.autoplayed = false;
            }
        }"
     @open-modal.window="resetAutoplay"
>

    <div class="flex h-full flex-col justify-center items-center" x-show="loading">
        <x-filament::loading-indicator class="h-10 w-10" />
        <span class="text-center font-bold">{{ __('filament-media-action::media-action.loading') }}</span>
    </div>

    <div class="mediaContainer w-full flex flex-col justify-center items-center h-full" x-show="!loading">
        @if ($mediaType === 'youtube')
            @php
                $youtubeId = '';

                // Parse the URL to get components
                $parsedUrl = parse_url($media);

                if (isset($parsedUrl['host'])) {
                    // Check if it's a youtu.be short URL
                    if (strpos($parsedUrl['host'], 'youtu.be') !== false) {
                        // Get the path and extract the video ID
                        $youtubeId = ltrim($parsedUrl['path'], '/');
                    }
                    // Check if it's a regular youtube.com URL
                    elseif (strpos($parsedUrl['host'], 'youtube.com') !== false) {
                        // Extract the query parameters and get the 'v' parameter
                        parse_str($parsedUrl['query'], $queryParams);
                        $youtubeId = $queryParams['v'] ?? '';
                    }
                }
            @endphp

            @if ($youtubeId)
                <iframe x-ref="mediaFrame" class="rounded-lg" width="100%"
                        src="https://www.youtube.com/embed/{{ $youtubeId }}{{ $autoplay ? '?autoplay=1' : '' }}"
                        frameborder="0"
                        style="aspect-ratio: 16 / 9;"
                        allowfullscreen></iframe>
            @else
                <p>Invalid YouTube URL.</p>
            @endif

        @elseif ($mediaType === 'audio')

            <audio x-ref="mediaFrame" class="rounded-lg w-full" controls @canplay="loading = false"
                   @loadeddata="loading = false"
                   @play="loading = false" {{ $preload == false ? 'preload="none"' : '' }}>
                <source src="{{ $media }}" type="{{ $mime }}">
                Your browser does not support the audio element.
            </audio>

        @elseif ($mediaType === 'video')

            <video x-ref="mediaFrame" class="rounded-lg" width="100%" style="aspect-ratio: 16 / 9;" controls playsinline
                   @canplaythrough="loading = false" {{ $preload == false ? 'preload="none"' : '' }}>
                <source src="{{ $media }}" type="{{ $mime }}">
                Your browser does not support the video tag.
            </video>

        @elseif ($mediaType === 'image')

            <img x-ref="mediaFrame" class="rounded-lg" src="{{ $media }}" alt="Media Image"
                 style="max-width: 100%; height: auto;" @load="loading = false">

        @elseif ($mediaType === 'pdf')

            <iframe x-ref="mediaFrame" class="rounded-lg" style="min-height: 600px"
                    src="{{ $media }}" width="100%" height="100%"
                    @load="loading = false"></iframe>

        @else
            <p>{{ __('filament-media-action::unsupported-media-type') }}</p>
        @endif
    </div>
</div>
