<?php
/**
 * Loads specified files and all files in specified directories, initialises dependencies
 */

namespace SMPLFY\boilerplate;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( __NAMESPACE__ . '\\bootstrap_boilerplate_plugin' ) ) {
    function bootstrap_boilerplate_plugin(): void {
        require_boilerplate_dependencies();

        if ( class_exists( DependencyFactory::class ) ) {
            DependencyFactory::create_plugin_dependencies();
        } else {
            error_log( 'Boilerplate: DependencyFactory not found.' );
        }
    }
}

/**
 * When adding a new directory to the custom plugin, remember to require it here
 */
function require_boilerplate_dependencies(): void {

    require_file( 'includes/enqueue_scripts.php' );
    require_file( 'admin/DependencyFactory.php' );

    require_directory( 'public/php/types' );
    require_directory( 'public/php/entities' );
    require_directory( 'public/php/repositories' );
    require_directory( 'public/php/usecases' );
    require_directory( 'public/php/adapters' );
}
