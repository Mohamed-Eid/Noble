<ul class="thumbnails">
<li><a class="thumbnail" href="{{$product->images[0]->image}}" title="{{$product->images[0]->name}}"><img id="largeImage" class="drift-demo-trigger" data-zoom="{{$product->images[0]->image}}" src="{{$product->images[0]->image}}" title="كنب قطعة واحدة&quot;" alt="كنب قطعة واحدة&quot;"></a>
<div class="large-images"><div class="detail"></div></div>
</li>
    
        <div id="carousel-images" class="slideshow-products owl-carousel" style="opacity: 1;">
			
        @foreach ($product->images as $index=>$image)
				<div class="item">
    <li class="image-additional">
        <a class="thumbnail" title="{{ $product->name }}"> 
            <img src="{{$image->image}}" title="{{ $product->name }}" alt="{{ $product->name }}">
        </a>
    </li>
				</div>
        @endforeach
        @foreach ($product->videos as $video)
        <div class="item">
            <li class="image-additional">
                <a class="thumbnail mfp-iframe" href="{{$video->video}}" title="اسم الفيديو"> 
                 <iframe width="90" height="85"
                 src="{{$video->video}}">
                 </iframe> 
                </a>
            </li>
        </div>
        @endforeach
			
			
			
        </div>
    

</ul>

{{--
<div class="bg-images">
<div class="app-figure" id="zoom-fig">
        <a id="Zoom-1" class="MagicZoom base_a" title="كنب قطعة واحدة&quot;"
            href="{{$product->images[0]->image}}?h=1400"
            data-zoom-image-2x="{{$product->images[0]->image}}?h=2800"
            data-image-2x="{{$product->images[0]->image}}?h=800"
        >
            <img src="{{$product->images[0]->image}}?h=400" class="base_img" srcset="{{$product->images[0]->image}}?h=800 2x"
                alt=""/>
        </a>
        

        <div class="selectors MagicScroll" data-options="arrows: inside">
			<div id="carousel-images" class="slideshow-products owl-carousel" style="opacity: 1;">
			
        @foreach ($product->images as $index=>$image)
				<div class="item">
                <a 
                    id="first-{{$index}}"
                    data-zoom-id="Zoom-1"
                    href="{{$image->image}}?h=1400"
                    data-image="{{$image->image}}?h=400"
                    data-zoom-image-2x="{{$image->image}}?h=2800"
                    data-image-2x="{{$image->image}}?h=800"
                >
                    <img id="first-{{$index}}" srcset="{{$image->image}}?h=120 2x" src="{{$image->image}}?h=60"/>
                </a>
				</div>
        @endforeach
        @foreach ($product->videos as $video)
        <div class="item">
        <div class="zoom-video">
        <iframe id="mario-video" src="{{$video->video}}" alt="" frameborder="0" allowfullscreen></iframe>
        <button id="video-fullscreen">View fullscreen video</button>
        </div>
        </div>
        @endforeach
			
			
			
        </div>
        </div>
</div>
</div>

<script type="text/javascript">
    var marioVideo = document.getElementById("mario-video")
        videoFullscreen = document.getElementById("video-fullscreen");

    if (marioVideo && videoFullscreen) {
        videoFullscreen.addEventListener("click", function (evt) {
            if (marioVideo.requestFullscreen) {
                marioVideo.requestFullscreen();
            }
            else if (marioVideo.msRequestFullscreen) {
                marioVideo.msRequestFullscreen();
            }
            else if (marioVideo.mozRequestFullScreen) {
                marioVideo.mozRequestFullScreen();
            }
            else if (marioVideo.webkitRequestFullScreen) {
                marioVideo.webkitRequestFullScreen();
                /*
                    *Kept here for reference: keyboard support in full screen
                    * marioVideo.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
                */
            }
        }, false);
    }

</script>


--}}
<script>
$('#carousel-images').owlCarousel({
	items: 6,   
	itemsDesktop : [1199,6],
	itemsDesktopSmall : [980,6],
	itemsTablet: [768,4],
	itemsTabletSmall: false,
	itemsMobile : [479,4],
	navigation: true,
	navigationText: ['<span class="fa fa-chevron-left"></span>', '<span class="fa fa-chevron-right"></span>'],
	pagination: true
});
	</script>

