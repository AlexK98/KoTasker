<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-light border-bottom shadow-sm">
	<h1 class="my-0 mr-md-auto">
		<a href="/" title="<?php echo 'KoTasker';?>"><?php echo 'KoTasker';?></a>
	</h1>
	<?php if(isset($logged) && $logged):?>
		<a class="btn btn-outline-primary" href="/signout">Sign Out</a>
	<?php else:?>
		<a class="btn btn-outline-primary" href="/signin">Sign in</a>
	<?php endif;?>
</div>

<div>
	<?php if(isset($textUserName)) {echo $textUserName;}?>
</div>