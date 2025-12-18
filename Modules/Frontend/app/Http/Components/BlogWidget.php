<?php

namespace Modules\Frontend\Http\Components;

use Illuminate\View\Component;
use Modules\SysAdmin\Interfaces\BlogInterface;

class BlogWidget extends Component
{
    public function __construct(
        protected BlogInterface $blog,
        public int $limit = 4,
        public string $title = 'LATEST BLOGS',
    ) {}

    public function render()
    {
        return view('frontend::components.blog', [
            'blogs' => $this->blog->recentFrontend(),
        ]);
    }
}
