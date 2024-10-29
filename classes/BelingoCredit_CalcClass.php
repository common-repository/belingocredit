<?php

if(!class_exists('BelingoCredit_CalcClass')) {

	class BelingoCredit_CalcClass {

		private $summ;
		private $period;
		private $procent;
		private $credit_adv_payment;
		private $credit_adv_month_payment;
		private $credit_type;
		private $currency;
		public $payment;
		public $overpayment;
		public $table;
		public $result;

		public function __construct() {
			$this->result = false;
			$this->table = [];
		}

		public function get_currency() {

			$currency = [
				'RUB' => __('rub.', 'belingocredit'),
				'USD' => __('$', 'belingocredit'),
				'EUR' => __('Euro', 'belingocredit')
			];

			return $currency[$this->currency];

		}

		public function set($key, $value) {
			$this->{$key} = $value;
		}

		public function get($key) {
			return $this->{$key};
		}

		public function format_payment() {
			if(preg_match('/\.\.\./', $this->payment)) {
				return $this->payment;
			}
			return $this->calc_number_format($this->payment);
		}

		public function format_overpayment() {
			return $this->calc_number_format($this->overpayment);
		}

		private function calc_number_format($val) {
			return number_format($val, 2, ',', ' ');
		}

		public function process() {
			if(!empty($this->credit_adv_payment)) {
				$credit_adv_payment = $this->credit_adv_payment;
			}else{
				$credit_adv_payment = 0;
			}
			if(!empty($this->credit_adv_month_payment)) {
				$credit_adv_month_payment = $this->credit_adv_month_payment;
				$credit_adv_period_payment = $credit_adv_month_payment*$this->period;
			}else{
				$credit_adv_month_payment = 0;
				$credit_adv_period_payment = 0;
			}
			$this->summ += $credit_adv_payment;
			$month_procent = $this->procent/100/12;
			if($this->credit_type == 'annu') {
				$month_procent = $this->procent/100/12;
				$payment = $this->summ*($month_procent/(1-pow((1+$month_procent),-$this->period)));
				$this->payment = round($payment);
				$this->overpayment = $this->payment*$this->period-$this->summ+$credit_adv_period_payment;
			}elseif($this->credit_type == 'def') {
				$payment = $this->summ/$this->period;
				$this->payment = $payment;
			}
			$debt = $this->summ;
			$overpayment = 0;
			$payments_ar = [];
			for ($period=1; $period <= $this->period; $period++) {
				if($this->credit_type == 'annu') {
					$procent_summ = $debt*$month_procent;
					$debt_summ = $payment-$procent_summ;
				}elseif($this->credit_type == 'def') {
					$procent_summ = $debt*$month_procent;
					$debt_summ = $this->payment;
					$payment = $this->payment+$procent_summ;
					$overpayment += $procent_summ;
					$payments_ar[] = $payment;
				}
				$debt -= $debt_summ;
				$this->table[] = [
					'pay_id' => $period,
					'payment' => round($payment,2),
					'debt_summ' => round($debt_summ,2),
					'procent_summ' => round($procent_summ,2),
					'month_adv_payment' => $credit_adv_month_payment,
					'debt' => round($debt,2)
				];
			}
			if($this->credit_type == 'def') {
				$this->overpayment = $overpayment+$credit_adv_period_payment;
				$this->payment = $this->calc_number_format(max($payments_ar)).' ... '.$this->calc_number_format(min($payments_ar));
			}
			$this->result = true;
		}

	}

}

?>