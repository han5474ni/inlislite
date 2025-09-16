<?php

/**
 * DEPRECATED: This controller is kept for backward compatibility only.
 * All public page logic has been consolidated into \App\Controllers\PublicController.
 *
 * This class now simply extends the consolidated controller to avoid code duplication
 * and potential conflicts across namespaces.
 */

namespace App\Controllers\Public;

// Delegate all behavior to the consolidated controller in the root App\Controllers namespace
class PublicController extends \App\Controllers\PublicController
{
    // Intentionally left empty
}
