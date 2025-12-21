 <!-- Custom Block Area Start -->
 <section class="about-area mb-60px">
     <div class="container">
         <div class="container-inner">
             <div class="row">
                 <!-- Banner Area Start -->
                 <div class="testimonial-slider-wrapper">

                     @forelse ($testimonials as $testimonial)
                         @php
                             $imageUrl = $testimonial->image
                                 ? \Modules\SysAdmin\Helpers\ImageUploader::getFilePath(
                                     $testimonial->image,
                                     $testimonial->created_at,
                                     'thumbnail',
                                 )
                                 : asset('assets/images/testimonial-image/default.png');
                         @endphp

                         <div class="testimonial-slider-item text-center">

                             <div class="testimonial-image">
                                 <img src="{{ $imageUrl }}" alt="{{ $testimonial->name }}" class="testimonial-avatar">
                             </div>

                             <div class="testimonial-content">
                                 <p>
                                     {{ \Illuminate\Support\Str::limit(strip_tags($testimonial->content), 140) }}
                                 </p>
                             </div>

                             <div class="testimonial-author">
                                 <h4>{{ $testimonial->name }}</h4>
                             </div>

                         </div>

                     @empty
                         <p class="text-center">No testimonials available.</p>
                     @endforelse

                 </div>
                 <!-- Banner Area End -->
             </div>
         </div>
     </div>
     </div>
 </section> <!-- Custom Block Area End -->
