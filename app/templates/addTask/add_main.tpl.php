<h2 class="mb-3"><?php if(isset($pageName)) {echo $pageName;}?></h2>
<section>
	<form method="post" action="/add" autocomplete="off" novalidate>
		<table class="table">
			<tbody>
				<tr>
					<th class="text-muted" style="width: 140px; vertical-align: middle">
						<label for="username">
							<span style="color: red" title="Required">*</span> Name
						</label>
					</th>
					<td>
						<input type="text" id="username" name="username" class="form-control"
							title="Please enter your name" required
							placeholder="<?php if(isset($phName)) {echo $phName;}?>"
							value="<?php if(isset($name) && !empty($name)) {echo $name;} ?>"/>
					</td>
				</tr>
				<tr>
					<th class="text-muted" style="vertical-align: middle">
						<label for="email">
							<span style="color: red" title="Required">*</span> Email
						</label>
					</th>
					<td>
						<input type="email" id="email" name="email" class="form-control"
							title="Please enter valid e-mail address" required
							placeholder="<?php if(isset($phEmail)) {echo $phEmail;}?>"
							value="<?php if(isset($email) && !empty($email)) {echo $email;} ?>"/>
					</td>
				</tr>
				<tr>
					<th class="text-muted" style="vertical-align: middle">
						<label for="description">
							<span style="color: red" title="Required">*</span> Description
						</label>
					</th>
					<td>
						<textarea id="description" name="description" class="form-control" rows="5" maxlength="512" required
							placeholder="<?php if(isset($phDescr)) {echo $phDescr;}?>"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" class="btn btn-primary" name="submit" value="AddTask">Add Task</button>
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