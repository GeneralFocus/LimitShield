# LimitShield

LimitShield is a Laravel middleware package designed to manage and enforce API rate limiting efficiently. It provides configurable limits, supports IP-based and user-based limiting, integrates with Redis for distributed rate limiting, and allows customizable responses for rate limit breaches.

## Installation

You can install the package via Composer:

```bash
composer require generalfocus/limitshield

'''bash

## Usage

Route::middleware('limitshield')->group(function () {
    // Your protected routes...
});


Route::get('api/users', function () {
    // Your API logic...
})->middleware('limitshield:limit=100,duration=60');

# LimitShield
