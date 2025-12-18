<?php
/**
 * RegRepository
 *
 * Provides access to Gravity Forms entries for the "reg" form
 * using SMPLFY Core repository methods.
 */

namespace SMPLFY\boilerplate;

use SmplfyCore\SMPLFY_BaseRepository;
use SmplfyCore\SMPLFY_GravityFormsApiWrapper;
use WP_Error;

/**
 * @method static RegEntity|null get_one( $fieldId, $value )
 * @method static RegEntity|null get_one_for_current_user()
 * @method static RegEntity|null get_one_for_user( $userId )
 * @method static RegEntity[] get_all( $fieldId = null, $value = null, string $direction = 'ASC' )
 * @method static int|WP_Error add( RegEntity $entity )
 */
class RegRepository extends SMPLFY_BaseRepository {

    public function __construct( SMPLFY_GravityFormsApiWrapper $gravityFormsApi ) {

        // Tell the Core repository which Entity it returns
        $this->entityType = RegEntity::class;

        // Bind this repository to the "reg" Gravity Form
        $this->formId = FormIds::REG_FORM_ID;

        // Let the Core plugin handle everything else
        parent::__construct( $gravityFormsApi );
    }
}
