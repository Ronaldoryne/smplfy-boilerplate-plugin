<?php
/**
 * A factory class responsible for creating and initializing all dependencies used in the plugin
 */

namespace SMPLFY\boilerplate;

use SmplfyCore\SMPLFY_GravityFormsApiWrapper;

class DependencyFactory {

	/**
	 * Create and initialize all dependencies
	 *
	 * @return void
	 */
	static function create_plugin_dependencies() {
		$gravityFormsWrapper = new SMPLFY_GravityFormsApiWrapper();

		// Repositories
		$exampleRepository = new RegRepository( $gravityFormsWrapper );
		//Usecases
		$exampleUsecase     = new RegUsecase( $exampleRepository );
		$wpHeartbeatExample = new RegHeartbeatHandler( $exampleRepository );


		new GravityFormsAdapter( $exampleUsecase );
		new WordpressAdapter( $wpHeartbeatExample );
	}
}