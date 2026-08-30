@props(['on'])

<div
    x-data
    x-init="@this.on('{{ $on }}', () => { if (window.showSiteToast) { window.showSiteToast('success', @js(trim(strip_tags($slot->isEmpty() ? 'Your changes have been saved' : $slot)))); } })"
    style="display: none;"
    {{ $attributes }}
></div>
