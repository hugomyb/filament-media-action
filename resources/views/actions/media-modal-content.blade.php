<div class="w-full flex flex-col justify-center items-center h-full"
     x-data="{
            loading: true,

            init() {
                let mediaElement = this.$refs.mediaFrame;
                if (mediaElement) {
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
                } else {
                    this.loading = false;
                }
            }
        }"
>

    <template x-if="loading">
        <div class="flex h-full flex-col justify-center items-center">
            <x-filament::loading-indicator class="h-10 w-10" />
            <span class="text-center font-bold">{{ __('filament-media-action::media-action.loading') }}</span>
        </div>
    </template>

    <div class="mediaContainer w-full flex flex-col justify-center items-center h-full" x-show="!loading">
        @if ($mediaType === 'youtube')
            @php
                // Extract the YouTube video ID from the URL
                $queryString = parse_url($media, PHP_URL_QUERY);
                parse_str($queryString, $queryParams);
                $youtubeId = $queryParams['v'] ?? '';
            @endphp

            @if ($youtubeId)
                <iframe x-ref="mediaFrame" class="rounded-lg" width="100%"
                        src="https://www.youtube.com/embed/{{ $youtubeId }}"
                        frameborder="0"
                        style="aspect-ratio: 16 / 9;"
                        allowfullscreen></iframe>
            @else
                <p>Invalid YouTube URL.</p>
            @endif

        @elseif ($mediaType === 'audio')

            <audio x-ref="mediaFrame" class="rounded-lg w-full" controls @canplaythrough="loading = false"
                   @loadeddata="loading = false">
                <source src="{{ $media }}" type="audio/{{ pathinfo($media, PATHINFO_EXTENSION) }}">
                Your browser does not support the audio element.
            </audio>

        @elseif ($mediaType === 'video')

            <video x-ref="mediaFrame" class="rounded-lg" width="100%" style="aspect-ratio: 16 / 9;" controls
                   @canplaythrough="loading = false">
                <source src="{{ $media }}" type="video/{{ pathinfo($media, PATHINFO_EXTENSION) }}">
                Your browser does not support the video tag.
            </video>

        @elseif ($mediaType === 'image')

            <img x-ref="mediaFrame" class="rounded-lg" src="{{ $media }}" alt="Media Image"
                 style="max-width: 100%; height: auto;" @load="loading = false">

        @elseif ($mediaType === 'pdf')

            <iframe x-ref="mediaFrame" class="rounded-lg" style="min-height: 600px"
                    src="https://docs.google.com/gview?url={{ $media }}&embedded=true" width="100%" height="100%"
                    @load="loading = false"></iframe>

        @else
            <p>Unsupported media type.</p>
        @endif
    </div>
</div>
