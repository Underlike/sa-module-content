<?php

namespace Sa\Content\Api;

interface SyncUrlRewriteManagementInterface
{
    /**
     * POST for SyncUrlRewrite api
     * @param string $slug
     * @return string
     */
    public function postSyncUrlRewrite($slug);
}
