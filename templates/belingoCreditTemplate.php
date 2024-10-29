<div class="content__wrapper">
	<div class="creditform">
		<div class="creditform__container">
			<form action="" method="post">
				<div class="creditform__item">
					<input type="hidden" name="process_calc" value="1">
					<?php esc_html_e('Currency', 'belingocredit'); ?><br><select name="currency">
						<option value="<?php echo esc_attr('RUB');?>" <?php selected( $currency, 'RUB', true ); ?>><?php esc_html_e('Ruble', 'belingocredit'); ?></option>
						<option value="<?php echo esc_attr('USD');?>" <?php selected( $currency, 'USD', true ); ?>><?php esc_html_e('Dollar', 'belingocredit'); ?></option>
						<option value="<?php echo esc_attr('EUR');?>" <?php selected( $currency, 'EUR', true ); ?>><?php esc_html_e('Euro', 'belingocredit'); ?></option>
					</select>
				</div>
				<div style="clear:both;"></div>
				<div class="creditform__item">
					<?php esc_html_e('Credit amount', 'belingocredit')?><br><input type="text" name="credit_summ" value="<?php echo esc_attr($credit_summ); ?>">
				</div>
				<div class="creditform__item">
					<?php esc_html_e('Loan term, months', 'belingocredit')?><br><input type="text" name="credit_period" value="<?php echo esc_attr($credit_period); ?>">
				</div>
				<div class="creditform__item">
					<?php esc_html_e('Interest rate, %', 'belingocredit')?><br><input type="text" name="credit_procent" value="<?php echo esc_attr($credit_procent); ?>">
				</div>
				<div class="creditform__item">
					<?php esc_html_e('Additional one-time payment', 'belingocredit')?><br><input type="text" name="credit_adv_payment" value="<?php echo esc_attr($credit_adv_payment); ?>">
				</div>
				<div class="creditform__item">
					<?php esc_html_e('Additional monthly payment', 'belingocredit')?><br><input type="text" name="credit_adv_month_payment" value="<?php echo esc_attr($credit_adv_month_payment); ?>">
				</div>
				<div class="creditform__item">
					<?php esc_html_e('Calculation method', 'belingocredit')?><br><select name="credit_type">
						<option value="annu" <?php selected( $credit_type, 'annu', true ); ?>><?php esc_html_e('Annuity', 'belingocredit'); ?></option>
						<option value="def" <?php selected( $credit_type, 'def', true ); ?>><?php esc_html_e('Differentiated', 'belingocredit'); ?></option>
					</select>
				</div>
				<div style="clear: both"></div>
				<div class="creditform__item creditform__item__mobilehidden">&nbsp;</div>
				<div class="creditform__item creditform__submitbtn">
					<input type="submit" value="<?php esc_attr_e('Calculate', 'belingocredit')?>">
				</div>
			</form>
		</div>
	</div>
	<div style="clear: both"></div>
	<div class="creditresult">
		<?php if($calc->result) {?>
		<br>
		<?php esc_html_e('Monthly payment', 'belingocredit'); ?>: <b><?php echo esc_html($calc->format_payment().' '.$calc->get_currency()); ?></b><br>
		<?php esc_html_e('Overpayment on a loan', 'belingocredit'); ?>: <b><?php echo esc_html($calc->format_overpayment().' '.$calc->get_currency()); ?></b>
		<br>
		<br>
		<h2><?php esc_html_e('Payment schedule', 'belingocredit'); ?></h2>
		<div class="creditresult__table">
			<table>
				<tr>
					<th class="creditresult__pay_id">#</th>
					<th><?php esc_html_e('Monthly payment', 'belingocredit'); ?></th>
					<th><?php esc_html_e('Amortization', 'belingocredit'); ?></th>
					<th><?php esc_html_e('Interest repayment', 'belingocredit'); ?></th>
					<th><?php esc_html_e('Additional monthly payment', 'belingocredit'); ?></th>
					<th><?php esc_html_e('Remaining debt', 'belingocredit'); ?></th>
				</tr>
			<?php foreach($calc->table as $row) {?>
				<tr>
					<td class="creditresult__pay_id"><?php echo esc_html($row['pay_id']); ?></td>
					<td><?php echo esc_html($row['payment'].' '.$calc->get_currency()); ?></td>
					<td><?php echo esc_html($row['debt_summ'].' '.$calc->get_currency()); ?></td>
					<td><?php echo esc_html($row['procent_summ'].' '.$calc->get_currency()); ?></td>
					<td><?php echo esc_html($row['month_adv_payment'].' '.$calc->get_currency()); ?></td>
					<td><?php echo esc_html($row['debt'].' '.$calc->get_currency()); ?></td>
				</tr>
			<?php }?>
			</table>
		</div>
		<?php }?>
	</div>
</div>