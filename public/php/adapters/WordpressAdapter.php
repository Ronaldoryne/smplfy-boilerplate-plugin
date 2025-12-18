<?php

namespace SMPLFY\boilerplate;

class WordpressAdapter {

    private RegHeartbeatHandler $heartbeatHandler;

    public function __construct( RegHeartbeatHandler $heartbeatHandler ) {
        $this->heartbeatHandler = $heartbeatHandler;

        $this->register_hooks();
        $this->register_filters();
    }

    /**
     * Register WordPress hooks
     */
    public function register_hooks(): void {
        // Future WordPress actions go here
    }

    /**
     * Register WordPress filters
     */
    public function register_filters(): void {
        add_filter(
            'heartbeat_received',
            [ $this->heartbeatHandler, 'receive_heartbeat' ],
            10,
            2
        );
    }
}
