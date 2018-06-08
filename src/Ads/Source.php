<?php

namespace StayCalm1\Tt2\Ads;

interface Source
{
    /**
     * @param int $id
     * @return \StayCalm1\Tt2\Ads\Ad
     * @throws \StayCalm1\Tt2\Ads\UnrecoverableException
     */
    public function fetch($id);

    /**
     * @return string
     */
    public function getSourceName();
}