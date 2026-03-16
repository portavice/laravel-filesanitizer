<?php

namespace Portavice\LaravelFileSanitizer;

use Illuminate\Http\UploadedFile;
use SytxLabs\FileSanitizer\FileSanitizer as BaseFileSanitizer;

class FileSanitizerManager
{
    public function __construct(protected BaseFileSanitizer $sanitizer, protected array $config = [])
    {
    }

    public function getSanitizer(): BaseFileSanitizer
    {
        return $this->sanitizer;
    }

    public function process(string $inputPath, ?string $outputPath = null, ?bool $sanitizeAlways = null): array
    {
        return $this->sanitizer->process($inputPath, $outputPath, $sanitizeAlways ?? (bool) ($this->config['sanitize_always'] ?? false));
    }

    public function sanitizeAlways(string $inputPath, ?string $outputPath = null): array
    {
        return method_exists($this->sanitizer, 'sanitizeAlways') ? $this->sanitizer->sanitizeAlways($inputPath, $outputPath) : $this->sanitizer->process($inputPath, $outputPath, true);
    }

    public function processUploadedFile(UploadedFile $file, ?string $outputPath = null, ?bool $sanitizeAlways = null): array
    {
        return $this->process($file->getRealPath(), $outputPath, $sanitizeAlways);
    }

    public function safe(array $result): bool
    {
        $scan = $result['scan'] ?? null;
        if (is_object($scan) && property_exists($scan, 'safe')) {
            return (bool) $scan->safe;
        }
        if (is_array($scan) && array_key_exists('safe', $scan)) {
            return (bool) $scan['safe'];
        }
        return false;
    }

    public function issues(array $result): array
    {
        $scan = $result['scan'] ?? null;
        $issues = [];
        if (is_object($scan) && property_exists($scan, 'issues') && is_iterable($scan->issues)) {
            foreach ($scan->issues as $issue) {
                $issues[] = $issue;
            }
        }
        if (is_array($scan) && isset($scan['issues']) && is_iterable($scan['issues'])) {
            foreach ($scan['issues'] as $issue) {
                $issues[] = $issue;
            }
        }
        return $issues;
    }
}
