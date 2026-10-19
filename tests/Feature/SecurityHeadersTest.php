<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_login_page_returns_comprehensive_security_headers(): void
    {
        $response = $this->get('/login');

        $response->assertOk();

        // 1. Content Security Policy (Medium ZAP finding)
        $response->assertHeader('Content-Security-Policy');
        $csp = (string) $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString("default-src 'self'", $csp);
        $this->assertStringContainsString("frame-ancestors 'self'", $csp);
        $this->assertStringContainsString("object-src 'none'", $csp);
        $this->assertStringContainsString("base-uri 'self'", $csp);
        $this->assertStringContainsString("form-action 'self'", $csp);

        // 2. Clickjacking defense (Medium ZAP finding)
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');

        // 3. MIME-type sniffing defense (Low ZAP finding)
        $response->assertHeader('X-Content-Type-Options', 'nosniff');

        // 4. Referrer Policy & Permissions Policy
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy');
        $response->assertHeader('Cross-Origin-Opener-Policy', 'same-origin');
        $response->assertHeader('Cross-Origin-Resource-Policy', 'same-origin');

        // 5. Cache-Control on sensitive/auth routes (Informational ZAP finding)
        $cacheControl = (string) $response->headers->get('Cache-Control');
        $this->assertStringContainsString('no-store', $cacheControl);
        $this->assertStringContainsString('no-cache', $cacheControl);
        $this->assertStringContainsString('must-revalidate', $cacheControl);
    }

    public function test_hsts_header_is_sent_when_request_is_secure(): void
    {
        $response = $this->get('https://localhost/login');

        $response->assertOk();
        $response->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
    }

    public function test_hsts_header_is_sent_when_request_has_x_forwarded_proto_https(): void
    {
        $response = $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
        ])->get('/login');

        $response->assertOk();
        $response->assertHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
    }

    public function test_outgoing_cookies_enforce_httponly_and_samesite_flags(): void
    {
        $response = $this->get('/login');

        $response->assertOk();

        $cookies = $response->headers->getCookies();
        $this->assertNotEmpty($cookies);

        foreach ($cookies as $cookie) {
            $this->assertTrue(
                $cookie->isHttpOnly(),
                "Cookie [{$cookie->getName()}] must have the HttpOnly flag enabled."
            );
            $this->assertContains(
                strtolower((string) $cookie->getSameSite()),
                ['lax', 'strict'],
                "Cookie [{$cookie->getName()}] SameSite attribute should be lax or strict, got: {$cookie->getSameSite()}"
            );
        }
    }

    public function test_outgoing_cookies_are_secure_when_request_is_over_https(): void
    {
        $response = $this->withHeaders([
            'X-Forwarded-Proto' => 'https',
        ])->get('/login');

        $response->assertOk();

        $cookies = $response->headers->getCookies();
        $this->assertNotEmpty($cookies);

        foreach ($cookies as $cookie) {
            $this->assertTrue(
                $cookie->isSecure(),
                "Cookie [{$cookie->getName()}] must have the Secure flag enabled on HTTPS."
            );
        }
    }

    public function test_login_response_does_not_disclose_suspicious_html_comments(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $content = (string) $response->getContent();

        $this->assertStringNotContainsString('<!-- Password', $content);
        $this->assertStringNotContainsString('<!-- Login Form', $content);
        $this->assertStringNotContainsString('<!-- Email', $content);
        $this->assertStringNotContainsString('<!-- Session Status', $content);
        $this->assertStringNotContainsString('<!-- User/Email', $content);
        $this->assertStringNotContainsString('<!-- Lock icon', $content);
        $this->assertStringNotContainsString('<!-- Remember Me', $content);
        $this->assertStringNotContainsString('<!-- LOG IN', $content);
    }
}
