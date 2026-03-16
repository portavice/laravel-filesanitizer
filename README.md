# Laravel FileSanitizer

Laravel integration for [`sytxlabs/filesanitizer`](https://github.com/SytxLabs/FileSanitizer).

The upstream package is installed as `sytxlabs/filesanitizer` and uses the class `SytxLabs\FileSanitizer\FileSanitizer`.

## Installation

```bash
composer require portavice/laravel-filesanitizer
php artisan vendor:publish --tag=filesanitizer-config
```

## Usage

```php
use Portavice\LaravelFileSanitizer\Facades\FileSanitizer;

$result = FileSanitizer::process(storage_path('app/uploads/file.pdf'), null, true);

if (! FileSanitizer::safe($result)) {
    foreach (FileSanitizer::issues($result) as $issue) {
        echo is_object($issue) ? $issue->code : ($issue['code'] ?? 'unsafe');
        echo PHP_EOL;
    }
}
```

## Validation rule

```php
use Portavice\LaravelFileSanitizer\Rules\SafeFile;

$request->validate([
    'upload' => ['required', 'file', new SafeFile()],
]);
```

Or as a validator string rule:

```php
$request->validate([
    'upload' => ['required', 'file', 'safe_file'],
]);
```

## UploadedFile macro

```php
$result = $request->file('upload')->sanitize();
```

## Config

```php
return [
    'sanitize_always' => env('FILESANITIZER_SANITIZE_ALWAYS', false),
];
```
