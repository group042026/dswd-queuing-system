@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo-v2.1.png" class="logo" alt="Laravel Logo">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>

{{-- PAG NAKA HOST NA --}}
{{-- <tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img
                src="{{ asset('images/dswd-logo.png') }}"
                class="logo"
                alt="DSWD Logo"
                width="120"
                style="display: block; width: 120px; height: auto;"
            >
        </a>
    </td>
</tr> --}}