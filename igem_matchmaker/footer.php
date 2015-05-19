 <!-- Footer -->

</div>
<footer class="footer">
	<p class="pull-right"><a href="#">To the top</a></p>
	<p><b>iGEM Matchmaker v2.2</b></p><br/>
	<p>Designed and built with <a href="http://php.net/" target="_blank">PHP</a>, <a href="http://jquery.com/" target="_blank">jQuery</a> and <a href="http://twitter.github.com/bootstrap/" target="_blank">Twitter Bootstrap</a>.</p>
	<p>Icons by <a href="http://fortawesome.github.com/Font-Awesome/" target="_blank">Font Awesome</a> and <a href="http://www.famfamfam.com/" target="_blank">famfamfam.com</a>.</p>
	<p><br />Created by <a href="http://twitter.com/oveoyas" target="_blank">Ove Øyås</a> @ <a href="http://2012.igem.org/Team:NTNU_Trondheim" target="_blank">iGEM NTNU 2012</a> <br/><i class="icon-envelope-alt"></i> <a href="mailto:igem.ntnu@gmail.com">igem.ntnu@gmail.com</a></p>
</footer>
</div><!-- /container -->


<!-- Javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script src="extras/js/sorttable.js"></script>
<script src="bootstrap/js/bootstrap-transition.js"></script>
<script src="bootstrap/js/bootstrap-alert.js"></script>
<script src="bootstrap/js/bootstrap-modal.js"></script>
<!-- <script src="bootstrap/js/bootstrap-dropdown.js"></script> -->
<!-- <script src="bootstrap/js/bootstrap-scrollspy.js"></script> -->
<script src="bootstrap/js/bootstrap-tab.js"></script>
<script src="bootstrap/js/bootstrap-tooltip.js"></script>
<!-- <script src="bootstrap/js/bootstrap-popover.js"></script> -->
<script src="bootstrap/js/bootstrap-button.js"></script>
<script src="bootstrap/js/bootstrap-collapse.js"></script>
<!-- <script src="bootstrap/js/bootstrap-carousel.js"></script> -->
<!-- <script src="bootstrap/js/bootstrap-typeahead.js"></script> -->

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
var pkBaseURL = (("https:" == document.location.protocol) ? "https://folk.ntnu.no/oyas/adm/piwik/" : "http://folk.ntnu.no/oyas/adm/piwik/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 1);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://folk.ntnu.no/oyas/adm/piwik/piwik.php?idsite=1" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tracking Code -->

</body>
</html>
