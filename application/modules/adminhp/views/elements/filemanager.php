<?php 
$CI=&get_instance();
$CI->load->helper('directory');
?>
<section class="content-header">
	<h1><?php echo element($table_name,$table_list); ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo site_url('adminhp') ?>"><i class="glyphicon glyphicon-home"></i></a><span class="divider"></span></li>		
		<li class="active">
		Files Manager
		</li>
	</ol>                
</section>
<section class="content">
<div class="box box-primary borderless">
<div class="box-header">
            <div class="pull-left">
                <h3 class="box-title"><i class="fa fa-info-circle"></i>Files Manager</h3>
            </div>
            <div class="pull-right"></div>
            <div class="clearfix"><!-- --></div>
		</div>
<?php
	
	
	echo '<div class="box-body">';
		echo '<div>';
		echo ' <div class="">
						<h2>Files Manager</h2>
						
						</div>';
			echo '<div id="ckfinder" class="portlet-content">';
			
			?>
        		<script type="text/javascript">



			// This is a sample function which is called when a file is selected in CKFinder.

			function showFileInfo( fileUrl, data )

			{

				

				// Display additional information available in the "data" object.

				// For example, the size of a file (in KB) is available in the data["fileSize"] variable.

				if ( fileUrl != data['fileUrl'] )

					msg += '<b>File url:</b> ' + data['fileUrl'] + '<br />';

				msg += '<b>File size:</b> ' + data['fileSize'] + 'KB<br />';

				msg += '<b>Last modifed:</b> ' + data['fileDate'];



				// this = CKFinderAPI object

				this.openMsgDialog( "Selected file", msg );

			}



			// You can use the "CKFinder" class to render CKFinder in a page:

			var finder = new CKFinder();


			// This is a sample function which is called when a file is selected in CKFinder.

			finder.selectActionFunction = showFileInfo;

			finder.create();



			// It can also be done in a single line, calling the "static"

			// create( basePath, width, height, selectActionFunction ) function:

			// CKFinder.create( '../../', null, null, showFileInfo );



			// The "create" function can also accept an object as the only argument.

			// CKFinder.create( { basePath : '../../', selectActionFunction : showFileInfo } );



		</script>

           
              
			<?php
			echo '</div>';
		echo '</div>';
	echo '</div>';
?>
</div>
</section>