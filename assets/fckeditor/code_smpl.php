<?php
include("assets/fckeditor/fckeditor.php") ;
?> <?php		
					$oFCKeditor = new FCKeditor('specials') ;
					$oFCKeditor->BasePath 	=  base_url().'assets/fckeditor/' ;
					$oFCKeditor->Width		= '100%' ;
					$oFCKeditor->Height		= '350' ;
					$oFCKeditor->Value 		= 'testing';
					$oFCKeditor->ToolbarSet	= 'Default' ;
					$oFCKeditor->Create() ;		
					
			?>