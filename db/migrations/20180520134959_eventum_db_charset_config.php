<?php

/*
 * This file is part of the Eventum (Issue Tracking System) package.
 *
 * @copyright (c) Eventum Team
 * @license GNU General Public License, version 2 or later (GPL-2+)
 *
 * For the full copyright and license information,
 * please see the COPYING and AUTHORS files
 * that were distributed with this source code.
 */

use Eventum\Db\AbstractMigration;
use Eventum\ServiceContainer;

class EventumDbCharsetConfig extends AbstractMigration
{
    public function up(): void
    {
        $config = ServiceContainer::getConfig();
        $config['database']['charset'] = 'utf8';

        Setup::save();
    }
}