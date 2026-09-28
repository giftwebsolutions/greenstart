<?php

namespace Modules\SysAdmin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\SysAdmin\Interfaces\TestimonialInterface;

class TestimonialController extends Controller
{
    protected TestimonialInterface $testimonialRepository;

    public function __construct(TestimonialInterface $testimonialRepository)
    {
        $this->testimonialRepository = $testimonialRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sysadmin::testimonial.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sysadmin::testimonial.create');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $testimonial = $this->testimonialRepository->findOrFail($id);

        return view('sysadmin::testimonial.view', compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $testimonial = $this->testimonialRepository->findOrFail($id);

        return view('sysadmin::testimonial.edit', compact('testimonial'));
    }
}
