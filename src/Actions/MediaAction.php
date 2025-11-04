<?php

namespace Hugomyb\FilamentMediaAction\Actions;

use Closure;
use Filament\Actions\Action;
use Hugomyb\FilamentMediaAction\Concerns\HasMedia;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;

class MediaAction extends Action
{
    use HasMedia;

    public const TYPE_YOUTUBE = 'youtube';
    public const TYPE_AUDIO   = 'audio';
    public const TYPE_VIDEO   = 'video';
    public const TYPE_IMAGE   = 'image';
    public const TYPE_PDF     = 'pdf';
    public const TYPE_UNKNOWN = 'unknown';

    public Closure|string|null $media;

    public ?string $mediaType;

    public ?string $forcedMediaType = null;

    public ?string $mime = 'unknown';

    protected bool|Closure $hasAutoplay = false;

    protected array|Closure $mediaControlsList = [];

    public ?bool $preloadAuto = true;

    public static function getDefaultName(): ?string
    {
        return 'media';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalSubmitAction(false);

        $this->modalCancelAction(false);

        $this->modalContent(function () {
            return $this->getContentView();
        });
    }

    public function media(string|\Closure|null $url): static
    {
        $this->media = $url;

        return $this;
    }

    public function mediaType(string $type): static
    {
        $this->forcedMediaType = $type;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->evaluate($this->media, [
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('model'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('arguments'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('data'),
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('livewire'),
        ]);
    }

    public function autoplay(bool|\Closure $hasAutoplay = true): static
    {
        $this->hasAutoplay = $hasAutoplay;

        return $this;
    }

    public function hasAutoplay(): bool
    {
        return (bool) $this->evaluate($this->hasAutoplay, [
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
            'mediaType' => $this->mediaType,
        ]);
    }

    public function controlsList(array|Closure $list): static
    {
        $this->mediaControlsList = $list;

        return $this;
    }

    public function disableDownload(bool|Closure $when = true): static
    {
        return $this->addMediaControlToken('nodownload', $when);
    }

    public function disableFullscreen(bool|Closure $when = true): static
    {
        return $this->addMediaControlToken('nofullscreen', $when);
    }

    public function disableRemotePlayback(bool|Closure $when = true): static
    {
        return $this->addMediaControlToken('noremoteplayback', $when);
    }

    protected function addMediaControlToken(string $token, bool|Closure $when): static
    {
        if ($this->evaluate($when, [
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
        ])) {
            $current = (array) $this->evaluate($this->mediaControlsList, [
                ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
            ]);

            if (in_array($token, $current, true) === false) {
                $current[] = $token;
                $this->mediaControlsList = $current;
            }
        }

        return $this;
    }

    protected function getMediaControlsList(): ?string
    {
        $list = (array) $this->evaluate($this->mediaControlsList, [
            ...$this->resolveDefaultClosureDependencyForEvaluationByName('record'),
        ]);

        return filled($list) ? implode(' ', $list) : null;
    }

    protected function detectMediaType(): string
    {
        // If media type is forced, use it but still try to determine a suitable MIME
        if ($this->forcedMediaType) {
            // Avoid evaluating closures (which may require Livewire context) when possible
            $url = is_string($this->media) ? $this->media : null;
            if ($url !== null) {
                // This will set $this->mime when possible (based on extension or headers)
                $this->getMediaType($url);
            } else {
                // Unknown if we cannot safely evaluate
                $this->mime = 'unknown';
            }

            return $this->forcedMediaType;
        }

        return $this->getMediaType($this->getMedia());
    }

    protected function getMediaType(?string $url): ?string
    {
        // Check if the URL is a YouTube link
        if (preg_match('/(youtube\.com|youtu\.be)/', $url)) {
            return self::TYPE_YOUTUBE;
        }

        // Parse the URL to remove query parameters
        $parsedUrl = parse_url($url, PHP_URL_PATH);

        // Handle cases where the URL path ends with a slash (no file)
        if (str_ends_with($parsedUrl, '/')) {
            $parsedUrl = rtrim($parsedUrl, '/');
        }

        // Get path info from the parsed URL
        $pathInfo = pathinfo($parsedUrl);
        $extension = strtolower($pathInfo['extension'] ?? '');

        // Define media types and their extensions
        $mediaTypes = [
            self::TYPE_AUDIO => ['mp3', 'wav', 'ogg', 'aac', 'flac', 'm4a', 'wma'],
            self::TYPE_VIDEO => ['mp4', 'avi', 'mov', 'webm', 'mkv', 'flv', 'wmv', '3gp', 'ogv', 'm4v'],
            self::TYPE_IMAGE => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp', 'tiff', 'ico'],
            self::TYPE_PDF   => ['pdf'],
        ];

        // Check if the extension matches any media type
        foreach ($mediaTypes as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                $this->mime = "$type/$extension"; // Set the MIME type

                return $type;
            }
        }

        // If the extension is not found, try to use HTTP headers to detect the content type
        // This might fail for local URLs or when the server is not accessible
        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5, // 5 second timeout
                    'method' => 'HEAD', // Only get headers, not the full content
                ],
            ]);

            $headers = @get_headers($url, 1, $context);

            if (is_array($headers)) {
                $headers = array_change_key_case($headers, CASE_LOWER);

                $rawType = $headers['content-type'] ?? null;
                $contentType = is_array($rawType) ? reset($rawType) : $rawType;

                if ($contentType) {
                    $type = match (true) {
                        str_contains($contentType, 'audio') => self::TYPE_AUDIO,
                        str_contains($contentType, 'video') => self::TYPE_VIDEO,
                        str_contains($contentType, 'image') => self::TYPE_IMAGE,
                        str_contains($contentType, 'pdf') => self::TYPE_PDF,
                        default => null,
                    };


                    if ($type !== null) {
                        $this->mime = $contentType;

                        return $type;
                    }
                }
            }
        } catch (\Exception $e) {
            // If headers detection fails, we'll fall back to unknown type
            // This is common for local development URLs or when the server is not accessible
        }

        $this->mime = 'unknown';

        return self::TYPE_UNKNOWN;
    }

    public function preload(?bool $preloadAuto = true): static
    {
        $this->preloadAuto = $preloadAuto;

        return $this;
    }

    public function getContentView(): View|Htmlable
    {
        $this->mediaType = $this->detectMediaType();

        return view('filament-media-action::actions.media-modal-content', [
            'mediaType' => $this->mediaType,
            'media' => $this->getMedia(),
            'mime' => $this->mime,
            'autoplay' => $this->hasAutoplay(),
            'preload' => $this->preloadAuto,
            'controlsList' => $this->getMediaControlsList(),
        ]);
    }
}
