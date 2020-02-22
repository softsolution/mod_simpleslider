{if $is_uc}
<script type="text/javascript" src="/modules/mod_simpleslider/js/jquery.jcarousel.min.js" ></script>
    <link href="/modules/mod_simpleslider/css/jcarousel.css" rel="stylesheet" type="text/css" />
	{literal}
		<script type="text/javascript">

		function mycarousel_initCallback(carousel)
		{
			// Disable autoscrolling if the user clicks the prev or next button.
			carousel.buttonNext.bind('click', function() {
				carousel.startAuto(0);
			});

			carousel.buttonPrev.bind('click', function() {
				carousel.startAuto(0);
			});

			// Pause autoscrolling if the user moves with the cursor over the clip.
			carousel.clip.hover(function() {
				carousel.stopAuto();
			}, function() {
				carousel.startAuto();
			});
		};

		jQuery(document).ready(function() {
			jQuery('#mycarousel').jcarousel({
				auto: 1,
				wrap: 'last',
				initCallback: mycarousel_initCallback
			});
		});

		</script>	
	{/literal}
	
	  <div class="carousel">
		   <ul id="mycarousel" class="jcarousel-skin-tango">
			{foreach key=tid item=item from=$items}
			<li>
                            <div class="ss_wrap">
				<div class="ss_image">
                                    <a href="/catalog/item{$item.id}.html" alt="{$item.title|strip}">
                                        <img src="/images/catalog/medium/{$item.imageurl}.jpg" border="0" alt="{$item.title}" width="270">
                                    </a>
                                </div>
                                <div class="ss_desc_wrap">
                                    <div class="ss_title"><a href="/catalog/item{$item.id}.html" class="carousel_title_link">{$item.title|stripslashes}</a></div>
                                    <div class="ss_prise">{$item.price} руб.</div>
                                    <a class="ss_order" href="/catalog/item{$item.id}.html">Заказать</a>
                                </div>
                            </div>
			</li>    
			{/foreach}
		 </ul>
	  </div>

        {if $cfg.fulllink}
	    <div style="margin-top:10px; text-align:right; clear:both"><a style="text-decoration:underline" href="/catalog">Весь каталог</a></div>
	{/if}
{else}
	<p>Нет объектов для отображения</p>
{/if}


