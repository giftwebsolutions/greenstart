<?php

declare(strict_types=1);

namespace Modules\SysAdmin\Support;

use Illuminate\Support\HtmlString;

final class Icon
{
    /** @var array<string, string> */
    private const PATHS = [
        'grid' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="M21 21l-3.5-3.5"/>',
        'home' => '<path d="M4 11.5 12 4l8 7.5M6 10v10h12V10"/>',
        'box' => '<path d="M21 8l-9-5-9 5 9 5 9-5zM3 8v8l9 5 9-5V8M12 13v8"/>',
        'layers' => '<path d="M12 2 2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>',
        'tag' => '<path d="M3 11.5V4.5a1 1 0 0 1 1-1h7l10 10-8 8L3 11.5z"/><circle cx="7.5" cy="7.5" r="1.3"/>',
        'folder' => '<path d="M3 6.5A1.5 1.5 0 0 1 4.5 5h4l2 2.5h9A1.5 1.5 0 0 1 21 9v9.5A1.5 1.5 0 0 1 19.5 20h-15A1.5 1.5 0 0 1 3 18.5z"/>',
        'file' => '<path d="M6 2h9l5 5v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1zM14 2v6h6"/>',
        'users' => '<circle cx="9" cy="8" r="3.2"/><path d="M3.5 20a5.5 5.5 0 0 1 11 0M17 8.2a3 3 0 0 1 0 5.6M20.5 20a5 5 0 0 0-3-4.6"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19 12a7 7 0 0 0-.1-1l2-1.5-2-3.5-2.5 1A8 8 0 0 0 15 6l-.4-2.7h-4L10 6a8 8 0 0 0-1.5 1L6 6 4 9.5 6 11a7 7 0 0 0 0 2l-2 1.5L6 18l2.5-1A8 8 0 0 0 10 18l.5 2.7h4L15 18a8 8 0 0 0 1.5-1l2.5 1 2-3.5-2-1.5a7 7 0 0 0 .1-1z"/>',
        'message' => '<path d="M4 5h16v11H8l-4 4z"/>',
        'image' => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8" cy="9" r="2"/><path d="m21 15-5-5L5 20"/>',
        'book' => '<path d="M4 4.5A2.5 2.5 0 0 1 6.5 2H20v17H6.5A2.5 2.5 0 0 0 4 21.5zM20 19H6.5A2.5 2.5 0 0 0 4 21.5"/>',
        'logout' => '<path d="M15 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3M10 12h10M16 8l4 4-4 4"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'eye' => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>',
        'pencil' => '<path d="M4 20h4L18.5 9.5a2.1 2.1 0 0 0-3-3L5 17v3zM13.5 6.5l3 3"/>',
        'trash' => '<path d="M4 7h16M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2M6 7l1 13a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-13"/>',
        'chevron-down' => '<path d="M6 9l6 6 6-6"/>',
        'arrow-left' => '<path d="M20 12H4M10 6l-6 6 6 6"/>',
        'sort' => '<path d="M8 9l4-4 4 4M8 15l4 4 4-4"/>',
        'check' => '<path d="M5 12l5 5 9-10"/>',
        'info' => '<circle cx="12" cy="12" r="9"/><path d="M12 11v6M12 7.5h.01"/>',
        'lock' => '<rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
        'server' => '<rect x="3" y="3" width="18" height="7" rx="2"/><rect x="3" y="14" width="18" height="7" rx="2"/><path d="M7 6.5h.01M7 17.5h.01M11 6.5h6M11 17.5h6"/>',
        'refresh' => '<path d="M20 6v5h-5M4 18v-5h5M6.1 9A7 7 0 0 1 18.8 7.5L20 11M4 13l1.2 3.5A7 7 0 0 0 17.9 15"/>',
        'bolt' => '<path d="M13 2 5 14h7l-1 8 8-12h-7z"/>',
        'map' => '<path d="m3 6 6-3 6 3 6-3v15l-6 3-6-3-6 3zM9 3v15M15 6v15"/>',
    ];

    public static function get(string $name, string $class = 'h-[18px] w-[18px]'): HtmlString
    {
        $svg = '<svg class="'.e($class).'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.(self::PATHS[$name] ?? self::PATHS['grid']).'</svg>';

        return new HtmlString($svg);
    }
}
