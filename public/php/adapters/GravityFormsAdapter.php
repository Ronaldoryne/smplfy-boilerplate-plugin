<?php
/**
 * Adapter for handling Gravity Forms events
 */

namespace SMPLFY\boilerplate;

class GravityFormsAdapter {

    private RegUsecase $regUsecase;

    public function __construct( RegUsecase $regUsecase ) {
        $this->regUsecase = $regUsecase;

        $this->register_hooks();
        $this->register_filters();
    }

    /**
     * Register Gravity Forms hooks to handle custom logic
     */
    public function register_hooks(): void {

        // Form ID 5 = "reg"
        add_action(
            'gform_after_submission_5',
            [ $this->regUsecase, 'handle_after_submission' ],
            10,
            2
        );
    }

    /**
     * Register Gravity Forms filters to handle custom logic
     */
    public function register_filters(): void {
        // Add filters here if needed
    }
}
