<h2 class="mb-3"><?php if(isset($pageName)) {echo $pageName;}?></h2>
<section>
	<p>
		<a class="btn btn-secondary" href="/add">Add New Task</a>
	</p>
</section>
<section>
	<?php if(isset($logged, $tasks) && $logged):?>
	<?php foreach ($tasks as $task): ?>
	<form method="post" action="/edit/<?php echo $task['id'];?>" autocomplete="off" novalidate>
	<?php endforeach; ?>
		<table class="table">
			<thead class="thead-light">
				<tr>
					<th scope="col" style="width: 140px">Field</th>
					<th scope="col">Value</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($tasks as $task): ?>
				<tr>
					<th class="text-muted">Name</th>
					<td><?php echo $task['username'];?></td>
				</tr>
				<tr>
					<th class="text-muted">Email</th>
					<td><?php echo $task['email'];?></td>
				</tr>
				<tr>
					<th class="text-muted">
						<label for="description">Description</label>
					</th>
					<td>
						<textarea id="description" name="description" class="form-control" rows="2" maxlength="512" required
							placeholder="<?php if(isset($phDescr)) {echo $phDescr;}?>"><?php echo $task['description']; ?></textarea>
					</td>
				</tr>
				<tr>
					<th class="text-muted">Status</th>
					<td>
						<div class="form-check">
							<label class="form-check-label">
								<input class="form-check-input" type="checkbox" name="state" <?php if($task['state'] === 'completed') {echo 'checked';}?> value="completed"> Completed
							</label>
						</div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<button type="submit" class="btn btn-primary" name="submit" value="UpdateTask">Save Changes</button>
						<a class="btn btn-secondary" href="/view/<?php echo $task['id'];?>">Cancel</a>
						<a class="btn btn-outline-dark" href="/<?php if(isset($page)) {echo $page;}?>">Back to List</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</form>
	<?php endif; ?>

	<?php if(isset($msg, $msgStyle)):?>
		<div class="mt-3 alert <?php echo $msgStyle;?> alert-dismissible">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php {echo $msg;}?>
		</div>
	<?php endif;?>
</section>