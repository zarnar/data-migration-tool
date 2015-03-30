<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Migration\App\Step;

/**
 * Interface StepInterface
 */
interface StepInterface
{
    /**
     * Integrity check
     *
     * @return bool
     */
    public function integrity();

    /**
     * Run step
     *
     * @return bool
     */
    public function run();

    /**
     * Volume check
     *
     * @return bool
     */
    public function volumeCheck();

    /**
     * @return mixed
     */
    public function rollback();

    /**
     * Get step title
     *
     * @return string
     */
    public function getTitle();
}