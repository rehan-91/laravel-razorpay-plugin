# Laravel Razorpay Plugin

A lightweight Laravel plugin to integrate Razorpay payment gateway.

## Features

- Create Razorpay Orders
- Frontend Blade Test Page
- Verify Razorpay Signature

## Installation

```bash
composer require rehan/laravel-razorpay-plugin
php artisan vendor:publish --tag=razorpay-config
php artisan vendor:publish --tag=razorpay-views
```

## .env

```
RAZORPAY_KEY=your_razorpay_key
RAZORPAY_SECRET=your_razorpay_secret
```

## Test

Visit `/razorpay/test` to run a test payment flow.

## License

MIT © Rehan Nawaz
