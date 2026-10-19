<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Remove server and backend signatures to prevent fingerprinting
        $response->headers->remove('X-Powered-By');
        if (function_exists('header_remove')) {
            @header_remove('X-Powered-By');
        }

        // Determine if request is secure or forwarded from HTTPS reverse proxy / Cloudflare
        $isHttps = $request->isSecure() || strtolower((string) $request->header('x-forwarded-proto')) === 'https';

        // 1. Content Security Policy (CSP)
        $host = $request->getHost();
        $scriptSrc = ["'self'", "'unsafe-inline'", "'unsafe-eval'", 'https://cdn.jsdelivr.net', 'https://challenges.cloudflare.com'];
        $styleSrc = ["'self'", "'unsafe-inline'", 'https://fonts.googleapis.com', 'https://fonts.bunny.net'];
        $connectSrc = ["'self'", 'ws:', 'wss:', 'http:', 'https:', 'https://psgc.cloud', 'https://cdn.jsdelivr.net', 'https://challenges.cloudflare.com'];

        // In local/development environment, allow Vite dev server and HMR WebSockets
        if (! app()->isProduction()) {
            $devHosts = [
                'http://localhost:*',
                'http://127.0.0.1:*',
                'http://[::1]:*',
                "http://{$host}:*",
                'http://192.168.*:*',
                'http://10.*:*',
                'http://172.16.*:*',
            ];
            $devWs = [
                'ws://localhost:*',
                'ws://127.0.0.1:*',
                'ws://[::1]:*',
                "ws://{$host}:*",
                "wss://{$host}:*",
                'ws://192.168.*:*',
                'ws://10.*:*',
                'ws://172.16.*:*',
            ];

            $scriptSrc = array_merge($scriptSrc, $devHosts);
            $styleSrc = array_merge($styleSrc, $devHosts);
            $connectSrc = array_merge($connectSrc, $devHosts, $devWs);
        }

        $cspDirectives = [
            "default-src 'self'",
            'script-src '.implode(' ', array_unique($scriptSrc)),
            'style-src '.implode(' ', array_unique($styleSrc)),
            "font-src 'self' data: https://fonts.gstatic.com https://fonts.bunny.net",
            "img-src 'self' data: blob: https:",
            'connect-src '.implode(' ', array_unique($connectSrc)),
            "worker-src 'self' blob: https://cdn.jsdelivr.net",
            "frame-src 'self' https://challenges.cloudflare.com",
            "frame-ancestors 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
        ];

        if ($isHttps && app()->isProduction()) {
            $cspDirectives[] = 'upgrade-insecure-requests';
        }

        $response->headers->set('Content-Security-Policy', implode('; ', $cspDirectives));

        // 2. Clickjacking Defense
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 3. MIME-Type Sniffing Defense
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 4. Strict-Transport-Security (HSTS)
        if ($isHttps || app()->isProduction()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // 5. Referrer Policy & Cross-Origin Hardening
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('Permissions-Policy', 'camera=(self), microphone=(), geolocation=(), payment=()');

        // 6. Cache-Control for HTML and Sensitive Endpoints
        $contentType = (string) $response->headers->get('Content-Type');
        $isHtml = str_contains(strtolower($contentType), 'text/html');

        if ($isHtml || $request->is('login', 'admin/*', 'receptionist/*', 'social-worker/*', 'approving-officer/*', 'cashier/*')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        // 7. Cookie Hardening (HttpOnly, SameSite, Secure flags, scoping)
        foreach ($response->headers->getCookies() as $cookie) {
            $sameSite = strtolower((string) $cookie->getSameSite());
            if ($sameSite === 'none' || empty($sameSite)) {
                $sameSite = 'lax';
            }

            $secure = $cookie->isSecure() || $isHttps;

            $domain = $cookie->getDomain();
            if ($domain === 'null' || $domain === '') {
                $domain = null;
            }

            $response->headers->setCookie(
                $cookie->withHttpOnly(true)
                    ->withSameSite($sameSite)
                    ->withSecure($secure)
                    ->withDomain($domain)
            );
        }

        return $response;
    }
}
