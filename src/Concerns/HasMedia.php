<?php

namespace Hugomyb\FilamentMediaAction\Concerns;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

trait HasMedia
{
    public \Closure | string | null $media;

    public ?string $mediaType;

    public ?string $mime = 'unknown';

    protected bool | Closure $hasAutoplay = false;

    public ?string $preload = '';

    public static function getDefaultName(): ?string
    {
        return 'media';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->modal();

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

    public function getMedia(): ?string
    {
        return $this->evaluate($this->media, [
            'record' => $this->getRecordInstance()
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
            'record' => $this->getRecordInstance(),
            'mediaType' => $this->mediaType,
        ]);
    }

    protected function detectMediaType(): string
    {
        return $this->getMediaType($this->getMedia());
    }

    protected function getMediaType(?string $url): ?string
    {
        // Check if the URL is a YouTube link
        if (preg_match('/(youtube\.com|youtu\.be)/', $url)) {
            return 'youtube';
        }

        // Parse the URL to remove query parameters
        $parsedUrl = parse_url($url, PHP_URL_PATH);

        // Handle cases where the URL path ends with a slash (no file)
        if (substr($parsedUrl, -1) === '/') {
            $parsedUrl = rtrim($parsedUrl, '/');
        }

        // Get path info from the parsed URL
        $pathInfo = pathinfo($parsedUrl);
        $extension = strtolower($pathInfo['extension'] ?? '');

        // Define media types and their extensions
        $mediaTypes = [
            'audio' => ['mp3', 'wav', 'ogg', 'aac'],
            'video' => ['mp4', 'avi', 'mov', 'webm'],
            'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'],
            'pdf' => ['pdf'],
        ];

        // Check if the extension matches any media type
        foreach ($mediaTypes as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                $this->mime = "$type/$extension"; // Set the MIME type
                return $type;
            }
        }

        // If the extension is not found, use HTTP headers to detect the content type
        $headers = @get_headers($url, 1);
        if ($headers && isset($headers['Content-Type'])) {
            $contentType = is_array($headers['Content-Type']) ? $headers['Content-Type'][0] : $headers['Content-Type'];
            if (strpos($contentType, 'audio') !== false) {
                $this->mime = $contentType;
                return 'audio';
            } elseif (strpos($contentType, 'video') !== false) {
                $this->mime = $contentType;
                return 'video';
            } elseif (strpos($contentType, 'image') !== false) {
                $this->mime = $contentType;
                return 'image';
            } elseif (strpos($contentType, 'pdf') !== false) {
                $this->mime = $contentType;
                return 'pdf';
            }
        }

        $this->mime = 'unknown';
        return 'unknown';
    }

    public function preloadNone(): static
    {
        $this->preload = 'none';

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
            'preload' => $this->preload,
        ]);
    }

    private function getRecordInstance(): ?Model
    {
        if (method_exists($this, 'getRecord') && $this->getRecord()) {
            return $this->getRecord() ? $this->getRecord() : null;
        } else {
            return null;
        }
    }
}
