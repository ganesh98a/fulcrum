<script src="/js/pdf.js"></script>

<?php 
	$init['access_level'] = 'anon';
	$init['application'] = 'www.axis.com';
	$init['cache_control'] = 'nocache';
	$init['debugging_mode'] = true;
	$init['display'] = false;
	$init['https'] = false;
	$init['https_admin'] = true;
	$init['https_auth'] = true;
	$init['no_db_init'] = false;
	$init['override_php_ini'] = false;
	$init['sapi'] = 'cli';
	$init['skip_always_include'] = true;
	$init['timer'] = true;
	$init['timer_start'] = false;
	require_once('lib/common/init.php');
	require_once('lib/common/File.php');
	$config = Zend_Registry::get('config'); 
	$fileManagerBasePath = $config->system->file_manager_base_path; 
	$date = date("Y-m-d");
	$fileName = $_GET['url'].'.pdf'; 
	$tempDir = $fileManagerBasePath.'temp/reports/'.$date.'/';
	$tempFilePath = $tempDir.$fileName;
	$RN_sha1 = sha1_file($tempFilePath);
	$tempFileNameDirNameOnly = 'reports/'.$date.'/'.$fileName;
	$url = '__temp_file__?tempFileSha1='.$RN_sha1.'&tempFilePath='.$tempFileNameDirNameOnly.'&tempFileName='.$fileName.'&tempFileMimeType=application/pdf&tempFileDir=reports&id=76wrQhuMZizg60wWPppeHFGijhGktEXs94bs0otFuxmTK5JPk2GtviAzLfqPvM4yTJ7KeRP6fsK96InPHvimqtUGUAgt1T8bGn1C';
?>
<?php if (preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) { ?>

	<canvas id="the-canvas" width="100%" height="100%" style="display: block;border:1px solid #000000;margin:0 auto;"></canvas>
	<div id="loading" style="text-align: center;position:relative;top: 30%;font-size:28px;">Loading.....</div>
	<div class="pdf-bottom-control" id="pdf-bottom-control">
		<span id="prev" style="width: 40px;float:left;"><img src="/images/buttons/button-rewind.png"></span>
		<span style="width: 265px;margin-top:3px;float:left;">Page: <!-- <span id="page_num"></span>  -->
			<input style="width:50px;height: 30px;font-size:18px;position: relative;top: -3px;" type="number" name="page_num" id="page_num" onchange="numChange(this.value)" value=''> / <span id="page_count"></span></span>
		<span  style="width: 40px;float:left;" id="next"><img src="/images/buttons/button-fast-forward.png"></span>
	</div>
	<style>
		.pdf-bottom-control {
		    background: #636262;
		    position: fixed;
		    bottom: 5px;
		    left: 0;
		    font-size: 24px;
		    right: 0;
		    text-align: center;
		    padding: 6px;
		    width: 350px;
		    margin: 0 auto;
		    border-radius: 3px;
		    color: #fff;
            font-family: sans-serif;
		}
		.pdf-bottom-control span {
			

		}
	</style>
<?php }else{ ?>
	<iframe src="<?php echo $_GET['url']; ?>" style="border:0;" width="98%" height="100%"></iframe>
<?php } ?>

<script type="text/javascript">
	var url = "<?php echo $url; ?>";
	
	var pdfjsLib = window['pdfjs-dist/build/pdf'];

	var pdfDoc = null,
	    pageNum = 1,
	    pageRendering = false,
	    pageNumPending = null,
	    scale = 1.5,
	    canvas = document.getElementById('the-canvas'),
	    ctx = canvas.getContext('2d');
	
	function renderPage(num) {

	  document.getElementById("loading").style.display = "none";

	  pageRendering = true;
	  
	  pdfDoc.getPage(num).then(function(page) {
	    var viewport = page.getViewport({scale: scale});
	    canvas.height = viewport.height;
	    canvas.width = viewport.width;

	    // Render PDF page into canvas context
	    var renderContext = {
	      canvasContext: ctx,
	      viewport: viewport
	    };
	    var renderTask = page.render(renderContext);

	    // Wait for rendering to finish
	    renderTask.promise.then(function() {
	      pageRendering = false;
	      if (pageNumPending !== null) {
	        // New page rendering is pending
	        renderPage(pageNumPending);
	        pageNumPending = null;
	      }
	    });
	  });

	  // Update page counters
	  document.getElementById('page_num').textContent = num;
	  document.getElementById('page_num').value = num;
	  pageNum = num;
	}
	
	function queueRenderPage(num) {
	  if (pageRendering) {
	    pageNumPending = num;
	  } else {
	    renderPage(num);
	  }
	}

	function numChange(pageNum){
		var page = parseInt(pageNum);
		queueRenderPage(page);
	}
	
	function onPrevPage() {
	  if (pageNum <= 1) {
	    return;
	  }
	  pageNum--;
	  queueRenderPage(pageNum);
	}
	document.getElementById('prev').addEventListener('click', onPrevPage);
	
	function onNextPage() {
	  if (pageNum >= pdfDoc.numPages) {
	    return;
	  }
	  pageNum++;
	  queueRenderPage(pageNum);
	}
	document.getElementById('next').addEventListener('click', onNextPage);
	
	pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
	  pdfDoc = pdfDoc_;
	  document.getElementById('page_count').textContent = pdfDoc.numPages;
	  renderPage(pageNum);
	});
</script>
