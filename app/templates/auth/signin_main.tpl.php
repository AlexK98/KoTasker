<h2 class="mb-3"><?php if(isset($pageName)) {echo $pageName;}?></h2>
<section>
	<form method="post" action="/signin" autocomplete="off" novalidate>
		<table class="table">
			<tbody>
			<tr>
				<th class="text-muted" style="width: 140px; vertical-align: middle">
					<label for="login">
						<span style="color: red" title="Required">*</span> Login
					</label>
				</th>
				<td>
					<input type="text" id="login" name="login" class="form-control"
					       title="Your Name, please." required
					       placeholder="<?php if(isset($phUser)) {echo $phUser;}?>"/>
				</td>
			</tr>
			<tr>
				<th class="text-muted" style="vertical-align: middle">
					<label for="password">
						<span style="color: red" title="Required">*</span> Password
					</label>
				</th>
				<td>
					<input type="password" id="password" name="password" class="form-control"
					       title="Your Password, please." required
					       placeholder="<?php if(isset($phPass)) {echo $phPass;}?>"/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<button type="submit" class="btn btn-primary" name="submit" value="SignIn">Sign In</button>
					<button type="reset" class="btn btn-dark">Reset</button>
					<a class="btn btn-outline-dark" href="/<?php if(isset($page)) {echo $page;}?>">Back to List</a>
				</td>
			</tr>
			</tbody>
		</table>
	</form>
	<?php if(isset($msg, $msgStyle)):?>
		<div class="mt-3 alert <?php echo $msgStyle;?> alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php {echo $msg;}?>
		</div>
	<?php endif;?>
</section>