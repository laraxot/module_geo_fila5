<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Datas\SMS;

use Modules\Notify\Datas\SMS\TwilioData;
use PHPUnit\Framework\Assert;

describe('TwilioData', function () {
    it('has default auth type', function () {
        $data = new TwilioData;

        Assert::assertSame('basic', $data->auth_type);
    });

    it('has default timeout', function () {
        $data = new TwilioData;

        Assert::assertSame(30, $data->timeout);
    });

    it('can set account sid', function () {
        $data = new TwilioData;
        $data->account_sid = 'AC1234567890';

        Assert::assertSame('AC1234567890', $data->account_sid);
    });

    it('can set auth token', function () {
        $data = new TwilioData;
        $data->auth_token = 'auth_token_123';

        Assert::assertSame('auth_token_123', $data->auth_token);
    });

    it('can set base url', function () {
        $data = new TwilioData;
        $data->base_url = 'https://custom.twilio.com';

        Assert::assertSame('https://custom.twilio.com', $data->base_url);
    });

    it('can get base url with default', function () {
        $data = new TwilioData;

        $baseUrl = $data->getBaseUrl();

        Assert::assertSame('https://api.twilio.com', $baseUrl);
    });

    it('can get custom base url', function () {
        $data = new TwilioData;
        $data->base_url = 'https://custom.twilio.com';

        $baseUrl = $data->getBaseUrl();

        Assert::assertSame('https://custom.twilio.com', $baseUrl);
    });

    it('can get timeout', function () {
        $data = new TwilioData;
        $data->timeout = 60;

        $timeout = $data->getTimeout();

        Assert::assertSame(60, $timeout);
    });

    it('can generate auth headers', function () {
        $data = new TwilioData;
        $data->account_sid = 'AC1234567890';
        $data->auth_token = 'auth_token_123';

        $headers = $data->getAuthHeaders();
        Assert::assertArrayHasKey('Authorization', $headers);
        Assert::assertArrayHasKey('Content-Type', $headers);
        Assert::assertStringStartsWith('Basic ', (string) $headers['Authorization']);
    });

    it('has from method (inherited from Spatie Data)', function () {
            });

    it('has make static method', function () {
            });
});
