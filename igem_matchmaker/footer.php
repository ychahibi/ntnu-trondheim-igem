 <!-- Footer -->

</div>
<div class="container">
	<div class="footer">
		<p class="pull-right"><a href="#">To the top</a></p>
		<p><b>iGEM Matchmaker v3.0</b></p><br/>
		<p>Designed and built with <a href="http://php.net/" target="_blank">PHP</a>, <a href="http://jquery.com/" target="_blank">jQuery</a> and <a href="http://twitter.github.com/bootstrap/" target="_blank">Twitter Bootstrap</a>.</p>
		<p>Icons by <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">Font Awesome</a> and <a href="http://www.famfamfam.com/" target="_blank">famfamfam.com</a>.</p>
		<p><br />Created by <a href="http://twitter.com/oveoyas" target="_blank">Ove Øyås</a> @ <a href="http://2012.igem.org/Team:NTNU_Trondheim" target="_blank">iGEM NTNU 2012</a> and <a href="http://twitter.com/ychahibi" target="_blank">Youssef Chahibi</a> @ <a href="http://2015.igem.org/Team:NTNU_Trondheim" target="_blank">iGEM NTNU 2015</a> <br/><i class="glyphicon glyphicon-envelope"></i> <a href="mailto:igem.ntnu@gmail.com">igem.ntnu@gmail.com</a></p> 

		<p><br />Developed on <a href="https://github.com/ychahibi/ntnu-trondheim-igem/">GitHub</a></p>
	</div>
</div>
</div><!-- /container -->


<!-- Javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="extras/js/sorttable.js"></script>
<script type="text/javascript">
	$('.tooltip-up').tooltip()
	$('.tooltip-down').tooltip({
		placement: 'bottom'
	})
	$('.tooltip-right').tooltip({
		placement: 'right'
	})

    $(document).ready(function(){
        if (navigator.appName == "Opera" && navigator.userAgent.match(/Version\/12\./)){
            $('#newEntry').removeClass('fade');
			$('#editEntry').removeClass('fade');
        }
    });

	$(document).ready(function() {
		$('#clickable tr').click(function() {
		    var href = $(this).find("a").attr("href");
		    if(href) {
		        window.location = href;
		    }
		});
	});

    $(window).scroll(function () { 
        var scrollPos = $(window).scrollTop();
        if (scrollPos > 0) {
            $(".control-panel").addClass("control-panel-fixed-top");
        } else {
            $(".control-panel").removeClass("control-panel-fixed-top");
        }
    });

	/*jQuery(function($) {
	  $('div.btn-group[data-toggle-name=*]').each(function(){
		var group   = $(this);
		var form    = group.parents('form').eq(0);
		var name    = group.attr('data-toggle-name');
		var hidden  = $('input[name="' + name + '"]', form);
		$('button', group).each(function(){
		  var button = $(this);
		  button.live('click', function(){
		      hidden.val($(this).val());
		  });
		});
	  });
	});*/

</script>

<!--<?php if( isset($_GET['new']) && !isset($_POST['new-entry']) ) {?>
<script>
	$(window).load(function(){
	    $('#newEntry').modal('show');
	});
</script><?php
}?>-->

<?php if( isset($_GET['id']) && !isset($_POST['update-entry']) && !isset($_POST['new-entry'])) {?>
<script>
	$(window).load(function(){
	    $('#editEntry').modal('show');
	});
</script><?php
}?>



<!-- Analytics
================================================== -->
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="http://almaaslab.nt.ntnu.no/piwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="http://almaaslab.nt.ntnu.no/piwik/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

</body>
</html>
