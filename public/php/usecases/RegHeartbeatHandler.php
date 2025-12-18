<?php

namespace SMPLFY\boilerplate;

class RegHeartbeatHandler {

    private RegRepository $regRepository;

    public function __construct( RegRepository $regRepository ) {
        $this->regRepository = $regRepository;
    }

    /**
     * Receive data from WP Heartbeat and respond
     */
    public function receive_heartbeat( array $response, array $data ): array {

        // If our custom data wasn't sent, do nothing
        if ( empty( $data['reg_heartbeat_data'] ) ) {
            return $response;
        }

        $customData = $data['reg_heartbeat_data'];
        $userId     = $customData['userId'] ?? null;

        if ( empty( $userId ) ) {
            $response['reg_entity_exists'] = false;
            return $response;
        }

        // Fetch reg entry for this user
        $regEntity = $this->regRepository->get_one_for_user( $userId );

        if ( ! empty( $regEntity ) ) {

            $response['reg_entity_exists'] = true;
            $response['reg_entity'] = array(
                'name'              => $regEntity->name,
                'email'             => $regEntity->email,
                'phone'             => $regEntity->phone,
                'eventSelection'    => $regEntity->eventSelection,
                'attendees'         => $regEntity->numberOfAttendees,
                'addOns'            => $regEntity->addOns,
                'totalCost'         => $regEntity->totalCost,
            );

        } else {
            $response['reg_entity_exists'] = false;
        }

        return $response;
    }
}
