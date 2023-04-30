<?php

if ( ! defined( 'ABSPATH' ) ){
	exit;
}

class Nexcess_Add_To_Team_Trigger extends AutomateWoo\Trigger{

/**
	 * Define which data items are set by this trigger, this determines which rules and actions will be available
	 *
	 * @var array
	 */
	public $supplied_data_items = array( 'order','customer' );

	/**
	 * Set up the trigger
	 */
	public function init() {
		$this->title = __( 'Custom Trigger', 'automatewoo-custom' );
		$this->group = __( 'Automattic', 'automatewoo-custom' );
	}

	/**
	 * Add any fields to the trigger (optional)
	 */
	public function load_fields() {}

	/**
	 * Defines when the trigger is run
	 */
	public function register_hooks() {
		add_action( 'automattic_custom_trigger', array( $this, 'catch_hooks' ) );
	}

	/**
	 * Catches the action and calls the maybe_run() method.
	 *
	 * @param $user_id
	 */
	public function catch_hooks( $order_id ) {
		//Adapted by Alan Zhu

		$logger = wc_get_logger();
		$logger->info( wc_print_r( "Customer Trigger started", true ), array( 'source' => 'custom-trigger' ) );
		$logger->info( wc_print_r( $order_id, true ), array( 'source' => 'custom-trigger' ) );
		
		$order = wc_get_order( $order_id );
		$logger->info( wc_print_r( $order, true ), array( 'source' => 'custom-trigger' ) );
		
		$customer = AutomateWoo\Customer_Factory::get_by_order( $order );
		$logger->info( wc_print_r( $customer, true ), array( 'source' => 'custom-trigger' ) );
		

		$this->maybe_run(array(
			'order'    => $order,
			'customer' => $customer,
		));
	}

	/**
	 * Performs any validation if required. If this method returns true the trigger will fire.
	 *
	 * @param $workflow AutomateWoo\Workflow
	 * @return bool
	 */
	public function validate_workflow( $workflow ) {

		// Get objects from the data layer
		$customer = $workflow->data_layer()->get_customer();

		// do something...

		return true;
	}

} // Nexcess_Add_To_Team_Trigger
