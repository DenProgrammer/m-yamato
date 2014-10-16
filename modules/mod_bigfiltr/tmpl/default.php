<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<script src="modules/mod_bigfiltr/assets/mod_bigfiltr.js"></script>
<div class="car_search_panel">
	<div class="car_search">
		<img src="components/com_manager/assets/reset.png" id="reset">
		<input type="text" value="" id="car_search" name="car[search]">
		<img src="components/com_manager/assets/search.png" id="search_img">
	</div>
	<div class="car_filter">
		<div class="">
			<div class="colls">
				<select id="car_marka" name="car[marka]">
					<option value="">Марка</option>
						<?php 
							if ($marka) {
								foreach($marka as $r) {
									$sel = ($selmarka == $r->marka) ? 'selected' : '';
									echo '<option '.$sel.' value="'.$r->marka.'">'.$r->marka.'</option>';
								}
							}
						?>
				</select>
			</div>
			<div class="colls">
				<select id="car_model" name="car[model]">
					<option value="">Модель</option>
						<?php 
							if ($models) {
								foreach($models as $r) {
									$sel = ($selmodel == $r->model) ? 'selected' : '';
									echo '<option '.$sel.' value="'.$r->model.'">'.$r->model.'</option>';
								}
							}
						?>
				</select>
			</div>
		</div>
		<div class="">
			<div class="colls">
				<select id="car_year1" name="car[data_in]">
					<option value="">Год выпуска от</option>
					<?php 
						$st = ($_GET['data_in']) ? $_GET['data_in'] : '';
					
						for($i = 1990; $i <= date("Y"); $i++) {
							$sel = ($st == $i) ? 'selected' : '';
							echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select> 
			</div>
			<div class="colls">
				<select id="car_year2" name="car[data_out]">
					<option value="">Год выпуска до</option>
					<?php 
						$st = ($_GET['data_out']) ? $_GET['data_out'] : '';
					
						for($i = 1990; $i <= date("Y"); $i++) {
							$sel = ($st == $i) ? 'selected' : '';
							echo '<option '.$sel.' value="'.$i.'">'.$i.'</option>';
						}
					?>
				</select>
			</div>
		</div>
	</div>
</div>