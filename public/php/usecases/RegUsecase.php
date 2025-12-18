<?php
/**
 * RegUsecase
 *
 * Runs business logic when the "reg" form (ID 5) is submitted.
 * Called by Gravity Forms adapter hook: gform_after_submission_5.
 *
 * Field IDs (reg form):
 *  - Name: 1 (Name field with sub inputs: 1.3 first, 1.6 last)
 *  - Email: 2
 *  - Phone: 6
 *  - Event Selection: 5
 *  - Number of Attendees: 10
 *  - Add-ons (checkbox w/ 3 choices): 11.1, 11.2, 11.3
 *  - Total Cost: 20
 *  - Terms & Conditions (checkbox): 13.1 (adjust if your input ID differs)
 */

namespace SMPLFY\boilerplate;

use SmplfyCore\SMPLFY_Log;
use SmplfyCore\WorkflowStep;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class RegUsecase {

    private RegRepository $regRepository;

    public function __construct( RegRepository $regRepository ) {
        $this->regRepository = $regRepository;
    }

    /**
     * Triggered after submission of Form ID 5 ("reg")
     *
     * Gravity Forms passes ($entry, $form) to gform_after_submission_{ID}
     *
     * @param array $entry Gravity Forms entry array
     * @param array $form  Gravity Forms form meta
     */
    public function handle_after_submission( array $entry, array $form ): void {

        // Build entity from the submitted entry
        $regEntry = new RegEntity( $entry );

        // Safe values (avoid notices if anything is missing)
        $entryId        = (int) ( $regEntry->id ?? rgar( $entry, 'id' ) );
        $name           = trim( ( $regEntry->nameFirst ?? '' ) . ' ' . ( $regEntry->nameLast ?? '' ) );
        $email          = (string) ( $regEntry->email ?? rgar( $entry, '2' ) );
        $phone          = (string) ( $regEntry->phone ?? rgar( $entry, '6' ) );
        $eventSelection = (string) ( $regEntry->eventSelection ?? rgar( $entry, '5' ) );
        $attendees      = (string) ( $regEntry->numberOfAttendees ?? rgar( $entry, '10' ) );
        $totalCost      = (string) ( $regEntry->totalCost ?? rgar( $entry, '20' ) );

        /**
         * ✅ Add-ons (checkbox with 3 choices)
         * Read directly from the entry using 11.1 / 11.2 / 11.3
         * This ensures values like "VIP" show up even if entity mapping isn't perfect yet.
         */
        $addons = array_filter(
            array(
                (string) rgar( $entry, '11.1' ),
                (string) rgar( $entry, '11.2' ),
                (string) rgar( $entry, '11.3' ),
            ),
            static fn( $v ) => trim( (string) $v ) !== ''
        );

        $addOnsString = ! empty( $addons ) ? implode( ', ', $addons ) : 'None';

        // Terms (checkbox input). Usually 13.1 when it’s a single checkbox.
        $termsAcceptedRaw = (string) ( $regEntry->termsAndConditions ?? rgar( $entry, '13.1' ) );
        $termsAccepted    = ! empty( $termsAcceptedRaw ) ? 'yes' : 'no';

        /**
         * ✅ REQUIRED FOR YOUR WP_DEBUG ASSIGNMENT
         * These will write to wp-content/debug.log when WP_DEBUG_LOG is enabled.
         */
        error_log( '[REG] gform_after_submission_5 fired' );
        error_log( '[REG] Entry ID: ' . $entryId );
        error_log( '[REG] Name: ' . $name );
        error_log( '[REG] Email: ' . $email );
        error_log( '[REG] Phone: ' . $phone );
        error_log( '[REG] Event: ' . $eventSelection );
        error_log( '[REG] Attendees: ' . $attendees );
        error_log( '[REG] Add-ons: ' . $addOnsString );
        error_log( '[REG] Total cost: ' . $totalCost );
        error_log( '[REG] Terms accepted: ' . $termsAccepted );

        /**
         * Extra debug (remove later if you want):
         * Helps confirm which checkbox input is being saved.
         */
        error_log(
            '[REG] ADDON RAW 11.1=' . (string) rgar( $entry, '11.1' ) .
            ' | 11.2=' . (string) rgar( $entry, '11.2' ) .
            ' | 11.3=' . (string) rgar( $entry, '11.3' )
        );

        /**
         * Core logging (Datadog via SMPLFY_Log)
         * Keep this as your “professional” logging.
         */
        SMPLFY_Log::info(
            'REG form submitted',
            array(
                'form_id'            => (int) rgar( $form, 'id' ),
                'form_title'         => (string) rgar( $form, 'title' ),
                'entry_id'           => $entryId,
                'name'               => $name,
                'email'              => $email,
                'phone'              => $phone,
                'eventSelection'     => $eventSelection,
                'numberOfAttendees'  => $attendees,
                'addOns'             => $addOnsString,
                'totalCost'          => $totalCost,
                'termsAndConditions' => $termsAccepted,
            )
        );

        /**
         * OPTIONAL: Move to a workflow step (only if you were instructed to do this)
         * Replace '10' with your real step ID if needed.
         */
        // WorkflowStep::send( '10', $regEntry->formEntry );

        /**
         * NOTE:
         * Gravity PDF generates the Event Ticket PDF via its own PDF settings.
         * This usecase is for extra automation after submission (logs, workflow, webhooks, updates, etc.).
         */
    }
}
