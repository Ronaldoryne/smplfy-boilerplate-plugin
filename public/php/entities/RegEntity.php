<?php
/**
 * RegEntity
 *
 * Represents the "reg" Gravity Form (Form ID 5)
 * Provides readable properties instead of raw GF field IDs
 *
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $eventSelection
 * @property string $numberOfAttendees
 * @property string $addOns
 * @property string $totalCost
 * @property string $termsAndConditions
 */

namespace SMPLFY\boilerplate;

use SmplfyCore\SMPLFY_BaseEntity;

class RegEntity extends SMPLFY_BaseEntity {

    public function __construct( $formEntry = array() ) {
        parent::__construct( $formEntry );

        // Link this entity to the correct Gravity Form
        $this->formId = FormIds::REG_FORM_ID;
    }

    /**
     * Map readable property names → Gravity Forms field IDs
     */
    protected function get_property_map(): array {
        return array(
            'nameFirst'          => '1.3',
            'nameSecond'         => '1.6',
            'email'              => '2',
            'phone'              => '6',
            'eventSelection'     => '5',
            'numberOfAttendees'  => '10',
            'addOnsone'          => '11.1',
            'addOnstwo'          => '11.2',
            'addOnsthree'        => '11.3',
            'totalCost'          => '20',
            'termsAndConditions' => '13.1',
        );
    }
}
