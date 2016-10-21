<?php

namespace jarrus90\WebsiteComments\migrations;

use jarrus90\User\migrations\RbacMigration;

class m160710_115500_comments_roles extends RbacMigration {

    public function up() {
        
        $admin = $this->authManager->getRole('admin');
        $adminSuper = $this->authManager->getRole('admin_super');
        $adminModerator = $this->authManager->getRole('admin_moderator');
        
        $supportAdmin = $this->createRole('website_comments_admin', 'Website comments administrator role');
        $supportModerator = $this->createRole('website_comments_moderator', 'Website comments moderator role');
        $this->assignChildRole($supportModerator, $admin);
        $this->assignChildRole($adminModerator, $supportModerator);
        $this->assignChildRole($supportAdmin, $supportModerator);
        $this->assignChildRole($adminSuper, $supportAdmin);
    }

    public function down() {
        
    }

}
