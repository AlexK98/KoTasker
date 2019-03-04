<h2 class="mb-3"><?php if(isset($pageName)) {echo $pageName;}?></h2>

<section>
	<div class="input-group">
<!--ADD TASK BUTTON-->
		<a class="btn btn-secondary mb-3 mr-3" href="/add">Add New Task</a>
<!--SORT TASKS CONTROLS-->
		<form class="form-inline mb-3" action="/<?php if(isset($currentPage)) {echo $currentPage;}?>" method="post">
			<div class="input-group">
				<div class="input-group-prepend">
					<label for="sortBy" class="input-group-text">Sort By:</label>
				</div>
				<select id="sortBy" class="custom-select" name="sortBy">
					<option value="id" <?php if(isset($sortBy, $selected)       && $sortBy === 'id') {echo $selected;} ?>>Id</option>
					<option value="username" <?php if(isset($sortBy, $selected) && $sortBy === 'username') {echo $selected;} ?>>Username</option>
					<option value="email" <?php if(isset($sortBy, $selected)    && $sortBy === 'email') {echo $selected;} ?>>E-mail</option>
					<option value="state" <?php if(isset($sortBy, $selected)    && $sortBy === 'state') {echo $selected;} ?>>Status</option>
				</select>
				<div class="input-group-append">
					<label for="sortOrder" class="input-group-text">Order:</label>
				</div>
				<select id="sortOrder" class="custom-select" name="sortOrder">
					<option value="ASC" <?php if(isset($sortOrder, $selected)  && $sortOrder === 'ASC') {echo $selected;} ?>>Ascending</option>
					<option value="DESC" <?php if(isset($sortOrder, $selected) && $sortOrder === 'DESC') {echo $selected;} ?>>Descending</option>
				</select>
				<div class="input-group-append">
					<button type="submit" name="submit" title="Sort Tasks" value="Sort" class="btn btn-secondary">Sort Tasks</button>
				</div>
			</div>
		</form>
	</div>
</section>

<!--TASKS TABLE-->
<section>
	<table class="table">
		<thead class="thead-dark">
			<tr>
				<th scope="col" style="width: 20px">ID</th>
				<th scope="col" style="width: 10%">Name</th>
				<th scope="col" style="width: 17%">Email</th>
				<th scope="col" style="width: auto">Description</th>
				<th scope="col" style="width: 10%; text-align: center">Status</th>
				<th scope="col" style="width: 130px; text-align: center">Operations</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($tasks)):?>
				<?php foreach ($tasks as $task): ?>
					<tr class="<?php if($task['state'] === 'completed') {echo 'table-success';}?>">
						<th scope="row" style="vertical-align: middle"><?php echo $task['id'];?></th>
						<td><?php echo $task['username'];?></td>
						<td style="vertical-align: middle"><?php echo $task['email'];?></td>
						<td style="vertical-align: middle"><?php echo $task['description'];?></td>
						<td style="text-align: center; vertical-align: middle"><?php echo ucfirst($task['state']);?></td>
						<td style="text-align: center; vertical-align: middle">
							<a class="btn btn-sm btn-outline-dark" href="/view/<?php echo $task['id'];?>">View</a>
							<?php if(isset($logged) && $logged):?>
								<a class="btn btn-sm btn-outline-dark" href="/edit/<?php echo $task['id'];?>">Edit</a>
							<?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
</section>

<!--PAGINATION-->
<section>
	<ul class="pagination justify-content-center">
		<?php if(isset($isPrevious)) : ?>
		<?php //if(isset($isPrevious, $currentPage) && $currentPage > 1) : ?>
			<li class="page-item <?php if(!$isPrevious) {echo 'disabled';}?>" title="First">
				<a class="page-link" href="/">First</a>
			</li>
			<li class="page-item <?php if(!$isPrevious) {echo 'disabled';}?>" title="Previous">
				<a class="page-link" href="/<?php if(isset($currentPage)) {echo $currentPage-1;}?>">Previous</a>
			</li>
		<?php endif; ?>

		<?php if(isset($pagination)) {echo $pagination;}?>

		<?php if(isset($isNext)) : ?>
		<?php //if(isset($isNext, $currentPage, $pageCount) && $currentPage < $pageCount):?>
			<li class="page-item <?php if(!$isNext) {echo 'disabled';}?>" title="Next">
				<a class="page-link" href="/<?php if(isset($currentPage)) {echo $currentPage+1;}?>">Next</a>
			</li>
			<li class="page-item <?php if(!$isNext) {echo 'disabled';}?>" title="Last">
				<a class="page-link" href="/<?php if(isset($pageCount)) {echo $pageCount;}?>">Last</a>
			</li>
		<?php endif; ?>
	</ul>
</section>