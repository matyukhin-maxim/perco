<div class="row">
	<div class="col-xs-12">

		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="glyphicon glyphicon-user"></i>&nbsp;
				<strong>Информация о сотруднике</strong>
			</div>
			<div class="panel-body">
				<div class="col-xs-6 col-sm-4 col-md-3">
					<img src="<?= $imageurl; ?>" alt="фото"/>
				</div>
				<div class="col-xs-12 col-sm-8 col-md-9">
					<div class="container-fluid">
						<?php foreach ($uinfo as $ukey => $uvalue): ?>
							<div class="row">
								<div class="col-xs-3 text-right title"><?= $ukey; ?></div>
								<div class="col-xs-9">
									<input class="form-control" type="text" readonly value="<?= $uvalue ?>"/>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>