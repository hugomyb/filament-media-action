<?php

namespace Hugomyb\FilamentMediaAction\Concerns;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;

trait HasMedia
{

    public \Closure|string|null $media;

    public ?string $mediaType;

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
                return $type;
            }
        }

        //if the $url has no extension, make a get request to the url and check the content type
        $headers = get_headers($url, 1);
        if (isset($headers['Content-Type'])) {
            $contentType = $headers['Content-Type'];
            if (strpos($contentType, 'audio') !== false) {
                return 'audio';
            } elseif (strpos($contentType, 'video') !== false) {
                return 'video';
            } elseif (strpos($contentType, 'image') !== false) {
                return 'image';
            } elseif (strpos($contentType, 'pdf') !== false) {
                return 'pdf';
            }
        }

        return 'unknown';
    }

    public function getContentView(): View|Htmlable
    {
        $this->mediaType = $this->detectMediaType();

        return view('filament-media-action::actions.media-modal-content', [
            'mediaType' => $this->mediaType,
            'media' => $this->getMedia(),
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
