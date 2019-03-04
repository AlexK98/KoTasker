<h2 class="mb-3"><?php if(isset($pageName)) {echo $pageName;}?></h2>
<section>
	<p><a class="btn btn-secondary" href="/add">Add New Task</a></p>
</section>
<section>
	<table class="table">
		<thead class="thead-light">
			<tr>
				<th scope="col" style="width: 140px">Field</th>
				<th scope="col">Value</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($tasks)):?>
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
					<th class="text-muted">Description</th>
					<td><?php echo $task['description'];?></td>
				</tr>
				<tr>
					<th class="text-muted">Status</th>
					<td><?php echo ucfirst($task['state']);?></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<?php if(isset($logged) && $logged):?>
							<a class="btn btn-primary" href="/edit/<?php echo $task['id'];?>">Edit Task</a>
						<?php endif; ?>
						<a class="btn btn-outline-dark" href="/<?php if(isset($page)) {echo $page;}?>">Back to List</a>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</section>