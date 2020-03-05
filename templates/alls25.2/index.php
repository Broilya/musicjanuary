<?php
/*--------------------------------------------------------------
# 2011 (for Joomla 1.6/1.7/2.5)
# Copyright (C) allscholsite.ru All Rights Reserved.
# License: Copyrighted Commercial Software
# Website: http://www.allscholsite.ru 
# Support: none
---------------------------------------------------------------*/
// No direct access.
defined('_JEXEC') or die;
JHTML::_('behavior.framework', true);
/* The following line gets the application object for things like displaying the site name */
$app = JFactory::getApplication();
$tplparams	= $app->getTemplate(true)->params;
?>


<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
	<jdoc:include type="head" />
	<!-- The following line loads the template CSS file located in the template folder. -->
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
	<!-- The following line loads the template JavaScript file located in the template folder. It's blank by default. -->
	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/CreateHTML5Elements.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/almenu.js"></script>
</head>


<body class="page_bg">
<header>
			<div class="top-menu">
			<div id="almenu">
				<jdoc:include type="modules" name="user3" />
			</div>
					<div id="search">
			<jdoc:include type="modules" name="user7" />
		</div>

		</div>
	<div class="clr"></div>
	</header>
	<div class="wrapper">
		<section id="content">
		
			
	<div class="clr"></div>
		<?php if ($this->countModules( 'user5 and user6' )) : ?>
				
		<div class="maincol">			 	
		<?php elseif( $this->countModules( 'user5' ) ) : ?>
		<div class="maincol_w_left">
		<?php elseif( $this->countModules( 'user6' ) ) : ?>
		<div class="maincol_w_right">
		<?php else: ?>
		<div class="maincol_full">
		<?php endif; ?>
				        		 
		
	   <div class="clr"></div>
	  <?php if($this->countModules('breadcrumbs')) : ?>
		<div class="breadcrumbs">
        <jdoc:include type="module" name="breadcrumbs" />
        </div>
		<?php endif; ?>
		<div class="clr"></div>
		<div class="usermods">
		<?php if($this->countModules('user1')) : ?>
	         <div id="user1">
	         <jdoc:include type="modules" name="user1" style="xhtml" />
	         </div> 
       <?php endif; ?> 
	   <?php if($this->countModules('user2')) : ?>
	         <div id="user2">
	         <jdoc:include type="modules" name="user2" style="xhtml" />
	         </div> 
       <?php endif; ?> 
	   </div> 
	    <div class="clr"></div>
		<?php if($this->countModules('bottom')) : ?>
			<div id="bottom">
		     <jdoc:include type="modules" name="bottom" style="xhtml" />
		  	</div>
          <?php endif; ?>
        <div class="clr"></div>
		<?php if( $this->countModules('user5') ) : ?>
			<div class="leftcol">
				<jdoc:include type="modules" name="user5" style="rounded"/>
			</div>
		<?php endif; ?>

			<div class="cont">
						<?php if ($this->getBuffer('message')) : ?>
						<div class="error">
							<jdoc:include type="message" />
						</div>
			<?php endif; ?>
				<jdoc:include type="component" />
				<?php if($this->countModules('user4')) : ?>
	                 <div id="user4"><jdoc:include type="modules" name="user4" style="xhtml" /></div> 
	                 <?php endif; ?> 
			</div>
	 		<?php if( $this->countModules('user6') ) : ?>
			<div class="rightcol">
				<jdoc:include type="modules" name="user6" style="rounded"/>
			</div>
		<?php endif; ?>
		<div class="clr"></div>
		<div class="bottommods">
		<?php if($this->countModules('user8')) : ?>
	         <div id="user8">
	         <jdoc:include type="modules" name="user8" style="xhtml" />
	         </div> 
       <?php endif; ?> 
	   <?php if($this->countModules('user9')) : ?>
	         <div id="user9">
	         <jdoc:include type="modules" name="user9" style="xhtml" />
	         </div> 
       <?php endif; ?> 
	   <?php if($this->countModules('user10')) : ?>
	         <div id="user10">
	         <jdoc:include type="modules" name="user10" style="xhtml" />
	         </div> 
       <?php endif; ?> 
	   </div> 

		<div class="clr"></div>
		<div id="footer">
				
				</div>
		</div>
		<?php if($this->countModules('user11')) : ?>
			<div id="user11">
		     <jdoc:include type="modules" name="user11" style="xhtml" />
		  	</div>
		 <?php endif; ?>
		 <div style=" padding: 5px 0;  font-size: 10px; text-align: center; background: #fff; color: #999999;">
						
	</div>
			</div>
	</section>
	
	</div>
</body>


</html>